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
    public function deploy()
    {
        $deployScriptPath = base_path('deploy.sh');
        
        if (!file_exists($deployScriptPath)) {
            return redirect()->back()->with('error', 'Script deploy.sh tidak ditemukan.');
        }

        // Jalankan script deploy.sh.
        // Kita menggunakan exec dan menangkap outputnya.
        // Tambahkan 2>&1 agar error juga tertangkap di output.
        exec("bash " . escapeshellarg($deployScriptPath) . " 2>&1", $output, $return_var);

        $outputStr = implode("\n", $output);

        if ($return_var !== 0) {
            return redirect()->back()->with('error', 'Deployment gagal (Kode: ' . $return_var . '). Output: ' . substr($outputStr, 0, 500));
        }

        return redirect()->back()->with('success', 'Deployment berhasil dijalankan!');
    }
}
