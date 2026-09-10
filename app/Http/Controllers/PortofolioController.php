<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Setting;
use Illuminate\Http\Request;

class PortofolioController extends Controller
{
    public function index()
    {
        $settings = Setting::allAsArray();
        
        $galeri = Galeri::aktif()->latest()->get();
        
        return view('portofolio', [
            'galeri' => $galeri,
            'site_name' => $settings['site_name'] ?? 'Konfigin IT Solutions',
        ]);
    }
}
