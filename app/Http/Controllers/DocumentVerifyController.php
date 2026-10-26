<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Setting;
use App\Models\Kontak;
use Illuminate\Http\Request;

class DocumentVerifyController extends Controller
{
    /**
     * Halaman verifikasi publik keaslian Invoice / Surat Penawaran via QR Code scan
     */
    public function verify($number)
    {
        // Decode jika encoded
        $number = urldecode($number);

        $document = Document::with(['items', 'client'])
            ->where('number', $number)
            ->first();

        $settings = Setting::allAsArray();
        $kontak = Kontak::first();

        return view('document_verify', compact('document', 'number', 'settings', 'kontak'));
    }
}
