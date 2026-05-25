<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Kurikulum;
use App\Models\Galeri;
use App\Models\Eservice;
use App\Models\Keunggulan;
use App\Models\Kontak;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::allAsArray();

        return view('landing', [
            'hero_title'    => $settings['hero_title']   ?? 'Infrastruktur Jaringan & Aplikasi Custom Sekali Putus',
            'hero_subtitle' => $settings['hero_subtitle'] ?? 'Konfigin IT Solutions menghadirkan pengembangan aplikasi kustom premium dan instalasi jaringan handal berlisensi sekali putus.',
            'profil_text'   => $settings['profil_text']   ?? '',
            'ig_username'   => $settings['instagram_username'] ?? 'santri_networkers',
            'site_name'     => $settings['site_name']     ?? 'Konfigin IT Solutions',
            'site_logo'     => $settings['site_logo']     ?? null,
            'kurikulum'     => Kurikulum::aktif()->get(),
            'galeri'        => Galeri::aktif()->get(),
            'eservice'      => Eservice::aktif()->get(),
            'keunggulan'    => Keunggulan::aktif()->get(),
            'kontak'        => Kontak::query()->first(),
        ]);
    }
}
