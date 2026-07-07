<?php

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;

function sendFcm($token, $title, $body)
{
    $credentials = new ServiceAccountCredentials(
        ['https://www.googleapis.com/auth/firebase.messaging'],
        storage_path('app/firebase/service-account.json')
    );

    $accessToken = $credentials->fetchAuthToken()['access_token'];

    $projectId = 'dadali-campernik-kbb';

    $response = Http::withToken($accessToken)
        ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body'  => $body,
                ],
            ]
        ]);

    return $response->json();
}

function setting($key, $default = null)
{
    return Cache::remember(
        "setting_{$key}",
        3600,
        fn() => \App\Models\Setting::where('setting_key', $key)
            ->whereNull('opd_id')
            ->whereNull('tahun_anggaran')
            ->value('setting_value') ?? $default
    );
}

if (!function_exists('encrypt_id')) {
    function encrypt_id($id)
    {
        $hash = new \Hashids\Hashids(env('ENC_KEY'), 8);
        return $hash->encode($id);
    }
}

if (!function_exists('decrypt_id')) {
    function decrypt_id($hash)
    {
        $decode = (new \Hashids\Hashids(env('ENC_KEY'), 8))->decode($hash);
        return $decode[0] ?? null;
    }
}

if (!function_exists('rupiah')) {
    // Format integer ke Rupiah
    function rupiah($angka, $rp = true, $sp = ".")
    {
        if ($angka === null) return $rp ? 'Rp 0' : '0';
        $hasil = number_format((int)$angka, 0, ',', $sp);
        return $rp ? 'Rp ' . $hasil : $hasil;
    }
}



if (!function_exists('parseRupiah')) {
    // Parse Rupiah string ke integer (untuk disimpan ke DB)
    function parseRupiah($string)
    {
        if ($string === null) return 0;

        // Hilangkan Rp, spasi, titik, koma, dll
        $clean = preg_replace('/[^0-9]/', '', $string);

        return (int) $clean;
    }
}
if (!function_exists('tanggalIndo')) {
    function tanggalIndo($tanggal)
    {
        if (!$tanggal) {
            return null;
        }

        $bulan = [
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        $pecah = explode('-', $tanggal);

        // Format: Y-m-d
        $tahun = $pecah[0];
        $bulanIndex = (int) $pecah[1];
        $hari = $pecah[2];

        return $hari . ' ' . $bulan[$bulanIndex] . ' ' . $tahun;
    }
}

if (!function_exists('tanggalIndo2')) {
    /**
     * Format tanggal menjadi dd/mm/yyyy atau versi dengan nama bulan
     *
     * @param string|Carbon $tanggal
     * @param bool $withNamaBulan
     * @return string
     */
    function tanggalIndoSm($tanggal, $withNamaBulan = false)
    {
        if (!$tanggal) return '-';

        $tgl = $tanggal instanceof Carbon ? $tanggal : Carbon::parse($tanggal);

        if ($withNamaBulan) {
            $bulan = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember'
            ];

            return $tgl->day . ' ' . $bulan[$tgl->month] . ' ' . $tgl->year;
        }

        return $tgl->format('d/m/Y'); // default dd/mm/yyyy
    }
}

if (!function_exists('curlGet')) {
    function curlGet($url, $headers = [])
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);
        $error    = curl_error($curl);

        curl_close($curl);

        // Jika error
        if ($error) {
            return [
                'status'  => false,
                'error'   => $error,
                'data'    => null
            ];
        }

        return [
            'status' => true,
            'data'   => json_decode($response, true)
        ];
    }
}

if (!function_exists('targetPersen')) {
    function targetPersen($tanggalAwal, $tanggalAkhir, $tanggalSekarang)
    {
        $totalHari = $tanggalAwal->diffInDays($tanggalAkhir);
        $berjalan  = $tanggalAwal->diffInDays($tanggalSekarang);

        if ($berjalan <= 0) return 0;
        if ($berjalan >= $totalHari) return 100;

        return round(($berjalan / $totalHari) * 100, 2);
    }
}

if (! function_exists('kurva_s')) {
    function kurva_s(float $x, float $k = 10): float
    {
        return 100 / (1 + exp(-$k * ($x - 0.5)));
    }
}
