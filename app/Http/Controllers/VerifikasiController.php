<?php

namespace App\Http\Controllers;

use App\Models\DocumentVerification;

class VerifikasiController extends Controller
{

    public function cek($token)
    {
        $doc = DocumentVerification::where('token', $token)->first();

        if (!$doc) {
            return view('verifikasi.invalid');
        }

        return view('verifikasi.valid', compact('doc'));
    }
}
