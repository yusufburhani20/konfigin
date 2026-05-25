<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use App\Models\Galeri;
use App\Models\Eservice;
use App\Models\Keunggulan;
use App\Models\Kontak;
use App\Models\Setting;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'total_kurikulum'  => Kurikulum::count(),
            'total_galeri'     => Galeri::count(),
            'total_eservice'   => Eservice::count(),
            'total_keunggulan' => Keunggulan::count(),
            'site_name'        => Setting::get('site_name', 'Konfigin IT Solutions'),
            'admin_nama'       => session('admin_nama', 'Admin'),
        ]);
    }
}
