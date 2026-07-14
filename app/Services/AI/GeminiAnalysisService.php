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
                    'maxOutputTokens' => 2048,
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

        $json = json_decode($text, true);

        if (json_last_error() !== JSON_ERROR_NONE) {

            throw new Exception(
                'Invalid JSON : ' . json_last_error_msg()
            );
        }

        return $json;
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
