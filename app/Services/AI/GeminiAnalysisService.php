<?php

namespace App\Services\AI;

use App\Models\AbcResult;
use App\Models\EmployeePerformanceAiAnalysis;
use App\Models\EmployeePerformanceResult;
use App\Models\MdpAnalysisResult;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class GeminiAnalysisService
{
    /**
     * Gemini API Key
     */
    protected string $apiKey;

    /**
     * Gemini Model
     */
    protected string $model;

    /**
     * Gemini Endpoint
     */
    protected string $endpoint;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');

        $this->model = config(
            'services.gemini.model',
            'gemini-2.5-flash'
        );

        $this->endpoint =
            "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent";
    }

    /**
     * Main Function
     */
    public function analyze(EmployeePerformanceResult $result): EmployeePerformanceAiAnalysis
    {
        try {

            /**
             * Load Relations
             */
            $result->load([

                'employee.department',

                'employee.position',

                'period',

                'details.kpiMaster',

                'latestRewardRecommendation'

            ]);

            /**
             * ABC Result
             */
            $abcResult = AbcResult::with('details.kpiMaster')

                ->where('period_id', $result->period_id)

                ->where('is_best', true)

                ->first();

            /**
             * MDP Result
             */
            $mdpResult = MdpAnalysisResult::with([

                'state',

                'action'

            ])

                ->where(
                    'employee_performance_result_id',
                    $result->id
                )

                ->first();

            /**
             * Build Prompt
             */
            $prompt = $this->buildPrompt(

                $result,

                $abcResult,

                $mdpResult

            );

            /**
             * Call Gemini
             */
            $response = $this->callGemini($prompt);

            /**
             * Parse Result
             */
            $data = $this->parseResponse($response);

            /**
             * Save Database
             */
            return $this->saveAnalysis(

                $result,

                $prompt,

                $response,

                $data

            );
        } catch (Exception $e) {

            Log::error(

                'Gemini Analysis Failed',

                [

                    'performance_result_id' => $result->id,

                    'message' => $e->getMessage(),

                    'trace' => $e->getTraceAsString()

                ]

            );

            throw $e;
        }
    }

    /**
     * Build Prompt
     */
    /**
     * Build Prompt
     */
    protected function buildPrompt(
        EmployeePerformanceResult $result,
        ?AbcResult $abc,
        ?MdpAnalysisResult $mdp
    ): string {

        $employee = $result->employee;

        /*
    |--------------------------------------------------------------------------
    | KPI Detail
    |--------------------------------------------------------------------------
    */

        $kpiText = "";

        foreach ($result->details as $detail) {

            $kpiText .=
                "- KPI : {$detail->kpiMaster->name}\n" .
                "  Score : {$detail->score}\n" .
                "  Weight : {$detail->weight}\n" .
                "  Weighted Score : {$detail->weighted_score}\n\n";
        }

        /*
    |--------------------------------------------------------------------------
    | ABC Weight
    |--------------------------------------------------------------------------
    */

        $abcText = "No ABC Result";

        if ($abc) {

            $abcText = "";

            foreach ($abc->details as $detail) {

                $abcText .=
                    "- {$detail->kpiMaster->name} : {$detail->weight}\n";
            }

            $abcText .= "\n";
            $abcText .= "Fitness : {$abc->fitness}\n";
        }

        /*
    |--------------------------------------------------------------------------
    | MDP
    |--------------------------------------------------------------------------
    */

        $mdpText = "No MDP Analysis";

        if ($mdp) {

            $mdpText =
                "State : " . optional($mdp->state)->name . "\n" .
                "Action : " . optional($mdp->action)->name . "\n" .
                "Reward : {$mdp->reward}\n" .
                "Recommendation : {$mdp->recommendation}";
        }

        /*
    |--------------------------------------------------------------------------
    | Previous Recommendation
    |--------------------------------------------------------------------------
    */

        $reward = optional(
            $result->latestRewardRecommendation
        )->recommendation ?? "None";

        /*
    |--------------------------------------------------------------------------
    | Prompt
    |--------------------------------------------------------------------------
    */

        $name = $employee->name ?? 'N/A';
        $department = $employee->department->name ?? 'N/A';
        $position = $employee->position->name ?? 'N/A';
        $employeeCode = $employee->employee_code ?? 'N/A';

        /*
        return <<<PROMPT

Anda adalah seorang Konsultan HR Senior, Pakar KPI, Pakar Artificial Bee Colony (ABC), dan Pakar Markov Decision Process (MDP).

Analisis kinerja karyawan berikut.

## Objective

Lakukan evaluasi menyeluruh terhadap performa karyawan berdasarkan:

1. KPI Score
2. Artificial Bee Colony (ABC) Optimization Result
3. Markov Decision Process (MDP) Decision Analysis

Analisis harus bersifat:
- Objektif
- Profesional
- Berbasis data
- Berorientasi pada peningkatan kinerja
- Tidak mengandung asumsi yang tidak didukung data

=================================================
DATA KARYAWAN
=================================================
Employee Code : {$employeeCode}

Nama Karyawan : {$name}

Departemen : {$department}

Jabatan : {$position}

=================================================
KINERJA
=================================================

Nilai Rata-rata : {$result->average_score}

Nilai Akhir : {$result->final_score}

Grade : {$result->grade}

Peringkat : {$result->rank}

=================================================
DETAIL KPI
=================================================

{$kpiText}

=================================================
HASIL OPTIMASI ABC
=================================================

{$abcText}

=================================================
HASIL ANALISIS MDP
=================================================

{$mdpText}

=================================================
RIWAYAT REWARD / PUNISHMENT
=================================================

{$reward}

=================================================
TUGAS
=================================================

Lakukan analisis mengenai:

1. Ringkasan keseluruhan kinerja karyawan.

2. Kelebihan karyawan.

3. Kekurangan karyawan.

4. Peluang peningkatan.

5. Risiko.

6. Rekomendasi secara rinci.

7. Rekomendasi reward.

8. Rekomendasi punishment (jika diperlukan).

9. Skor AI keseluruhan (0-100).

10. Tingkat keyakinan (0-100).

PENTING

Kembalikan HANYA JSON yang valid.

Kembalikan JSON.

Setiap field maksimal:

summary : 40 kata

strengths : 30 kata

weaknesses : 30 kata

opportunities : 30 kata

risks : 30 kata

recommendation : 40 kata

reward_recommendation : 20 kata

punishment_recommendation : 20 kata

Jangan melebihi batas tersebut.


Jangan berikan penjelasan apa pun.

Jangan gunakan markdown.

Jangan gunakan ```json.

Kembalikan tepat dengan format berikut.

{
    "summary":"",
    "strengths":"",
    "weaknesses":"",
    "opportunities":"",
    "risks":"",
    "recommendation":"",
    "reward_recommendation":"",
    "punishment_recommendation":"",
    "overall_score":95,
    "confidence":98
}

PROMPT;
*/
        return <<<PROMPT

Anda adalah seorang Konsultan HR Senior, Pakar KPI, Pakar Artificial Bee Colony (ABC), dan Pakar Markov Decision Process (MDP).

Analisis kinerja karyawan berikut.
        
## Objective

Lakukan evaluasi menyeluruh terhadap performa karyawan berdasarkan:

1. KPI Score
2. Artificial Bee Colony (ABC) Optimization Result
3. Markov Decision Process (MDP) Decision Analysis

Analisis harus bersifat:
- Objektif
- Profesional
- Berbasis data
- Berorientasi pada peningkatan kinerja
- Tidak mengandung asumsi yang tidak didukung data

=================================================
DATA KARYAWAN
=================================================
Employee Code : {$employeeCode}

Nama Karyawan : {$name}

Departemen : {$department}

Jabatan : {$position}

=================================================
KINERJA
=================================================

Nilai Rata-rata : {$result->average_score}

Nilai Akhir : {$result->final_score}

Grade : {$result->grade}

Peringkat : {$result->rank}

=================================================
DETAIL KPI
=================================================

{$kpiText}

=================================================
HASIL OPTIMASI ABC
=================================================

{$abcText}

=================================================
HASIL ANALISIS MDP
=================================================

{$mdpText}

=================================================
RIWAYAT REWARD / PUNISHMENT
=================================================

{$reward}

=================================================
TUGAS
=================================================

Lakukan analisis mengenai:

1. Ringkasan keseluruhan kinerja karyawan.

2. Kelebihan karyawan.

3. Kekurangan karyawan.

4. Peluang peningkatan.

5. Risiko.

6. Rekomendasi secara rinci.

7. Rekomendasi reward.

8. Rekomendasi punishment (jika diperlukan).

9. Skor AI keseluruhan (0-100).

10. Tingkat keyakinan (0-100).

PENTING 

Gunakan hanya data yang diberikan.

Berikan analisis singkat, objektif, profesional.

Output HARUS JSON valid.

Jangan gunakan markdown.

Jangan gunakan ```.

Jangan tambahkan penjelasan.

Setiap field maksimal:

summary 30 kata

strengths 20 kata

weaknesses 20 kata

opportunities 20 kata

risks 20 kata

recommendation 30 kata

reward_recommendation 15 kata

punishment_recommendation 15 kata

Format:

{
    "summary":"",
    "strengths":"",
    "weaknesses":"",
    "opportunities":"",
    "risks":"",
    "recommendation":"",
    "reward_recommendation":"",
    "punishment_recommendation":"",
    "overall_score":95,
    "confidence":98
}

PROMPT;
    }

    /**
     * Call Gemini API
     */

    /**
     * Call Gemini API
     */
    protected function callGemini(string $prompt): array
    {
        $response = Http::timeout(120)
            ->retry(3, 2000)
            ->acceptJson()
            ->post($this->endpoint . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.3,
                    'topK' => 40,
                    'topP' => 0.9,
                    'maxOutputTokens' => 4096,
                    'responseMimeType' => 'application/json'
                ]
            ]);

        switch ($response->status()) {

            case 401:
                throw new Exception('Gemini API Key is invalid.');

            case 403:
                throw new Exception('Gemini API access denied.');

            case 404:
                throw new Exception('Gemini model not found.');

            case 429:
                throw new Exception(
                    'Gemini API quota exceeded. Please check your billing or try again later.'
                );

            case 500:
            case 502:
            case 503:
                throw new Exception(
                    'Gemini server is temporarily unavailable.'
                );
        }

        if (!$response->successful()) {
            throw new Exception(
                'Gemini API Error : ' . $response->body()
            );
        }

        return $response->json();
    }

    /**
     * Parse Gemini Response
     */

    /**
     * Parse Gemini Response
     */
    protected function parseResponse(array $response): array
    {
        Log::debug('Gemini Finish', [
            'finishReason' => data_get(
                $response,
                'candidates.0.finishReason'
            ),

            'tokenCount' => data_get(
                $response,
                'usageMetadata.candidatesTokenCount'
            ),

            'promptTokenCount' => data_get(
                $response,
                'usageMetadata.promptTokenCount'
            ),

            'totalTokenCount' => data_get(
                $response,
                'usageMetadata.totalTokenCount'
            ),
        ]);


        $text = data_get(
            $response,
            'candidates.0.content.parts.0.text',
            ''
        );

        if (blank($text)) {
            throw new \Exception('Empty Gemini response.');
        }

        Log::debug('Gemini Raw Response', [
            'text' => $text,
        ]);

        // Hilangkan markdown
        $text = trim($text);
        $text = preg_replace('/^```json\s*/i', '', $text);
        $text = preg_replace('/^```\s*/i', '', $text);
        $text = preg_replace('/\s*```$/', '', $text);

        /*
    |--------------------------------------------------------------------------
    | Ambil JSON pertama yang valid
    |--------------------------------------------------------------------------
    */
        $start = strpos($text, '{');

        if ($start === false) {
            throw new \Exception('Gemini response does not contain JSON.');
        }

        $level = 0;
        $end = null;
        $length = strlen($text);

        for ($i = $start; $i < $length; $i++) {

            if ($text[$i] === '{') {
                $level++;
            }

            if ($text[$i] === '}') {
                $level--;

                if ($level === 0) {
                    $end = $i;
                    break;
                }
            }
        }

        if ($end === null) {
            throw new \Exception('Cannot detect end of JSON.');
        }

        $jsonText = substr(
            $text,
            $start,
            $end - $start + 1
        );

        Log::debug('Gemini Clean JSON', [
            'json' => $jsonText,
        ]);

        try {

            return json_decode(
                $jsonText,
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (\JsonException $e) {

            Log::error('Gemini JSON Error', [
                'message' => $e->getMessage(),
                'json' => $jsonText,
            ]);

            throw new \Exception(
                'Invalid JSON : ' . $e->getMessage()
            );
        }
    }

    protected function parseResponsex(array $response): array
    {

        $text =
            $response['candidates'][0]['content']['parts'][0]['text']
            ?? '';

        if (!$text) {
            throw new Exception('Empty Gemini response.');
        }

        /*
    |--------------------------------------------------------------------------
    | Remove Markdown
    |--------------------------------------------------------------------------
    */

        $text = str_replace(
            ['```json', '```'],
            '',
            trim($text)
        );



        Log::debug('Gemini Raw Text', [
            'text' => $text,
        ]);

        $text = trim($text);

        // hilangkan markdown
        $text = preg_replace('/```json|```/i', '', $text);

        // ambil hanya objek JSON
        $start = strpos($text, '{');
        $end   = strrpos($text, '}');

        if ($start !== false && $end !== false) {
            $text = substr($text, $start, $end - $start + 1);
        }

        //$json = json_decode($text, true);

        //$text = trim($text);


        // hapus markdown
        $text = preg_replace(
            '/```json|```/',
            '',
            $text
        );


        // hapus karakter kontrol
        $text = preg_replace(
            '/[\x00-\x1F\x80-\x9F]/u',
            '',
            $text
        );


        $json = json_decode(
            $text,
            true
        );


        if (json_last_error()) {

            throw new Exception(
                'Invalid JSON : ' .
                    json_last_error_msg()
            );
        }


        return $json;

        // if (json_last_error() !== JSON_ERROR_NONE) {

        //     throw new Exception(
        //         'Invalid JSON : ' . json_last_error_msg()
        //     );
        // }

        // return $json;
    }

    /**
     * Save Database
     */
    /**
     * Save Database
     */
    protected function saveAnalysis(
        EmployeePerformanceResult $result,
        string $prompt,
        array $response,
        array $data
    ): EmployeePerformanceAiAnalysis {

        return EmployeePerformanceAiAnalysis::updateOrCreate(

            [

                'performance_result_id' => $result->id

            ],

            [

                'provider' => 'Gemini',

                'model' => $this->model,

                'summary' => $data['summary'] ?? null,

                'strengths' => $data['strengths'] ?? null,

                'weaknesses' => $data['weaknesses'] ?? null,

                'opportunities' => $data['opportunities'] ?? null,

                'risks' => $data['risks'] ?? null,

                'recommendation' => $data['recommendation'] ?? null,

                'reward_recommendation'
                => $data['reward_recommendation'] ?? null,

                'punishment_recommendation'
                => $data['punishment_recommendation'] ?? null,

                'overall_score'
                => $data['overall_score'] ?? null,

                'confidence'
                => $data['confidence'] ?? null,

                'prompt'
                => $prompt,

                'response'
                => json_encode(
                    $response,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                ),

                'analyzed_at'
                => now()

            ]

        );
    }
}
