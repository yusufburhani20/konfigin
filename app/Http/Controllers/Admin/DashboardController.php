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
        $total_quotations = 0;
        $total_invoices = 0;
        $total_revenue = 0;
        try {
            $total_quotations = \App\Models\Document::quotations()->count();
            $total_invoices   = \App\Models\Document::invoices()->count();
            $total_revenue    = \App\Models\Document::invoices()->where('status', 'paid')->sum('total');
        } catch (\Exception $e) {
            // Table might not exist yet before migration
        }

        return view('admin.dashboard', [
            'total_kurikulum'  => Kurikulum::count(),
            'total_galeri'     => Galeri::count(),
            'total_eservice'   => Eservice::count(),
            'total_keunggulan' => Keunggulan::count(),
            'total_quotations' => $total_quotations,
            'total_invoices'   => $total_invoices,
            'total_revenue'    => $total_revenue,
            'site_name'        => Setting::get('site_name', 'Konfigin IT Solutions'),
            'admin_nama'       => session('admin_nama', 'Admin'),
        ]);
    }
    public function deploy(\Illuminate\Http\Request $request)
    {
        @ini_set('max_execution_time', '300');
        @set_time_limit(300);

        $deployScriptPath = base_path('deploy.sh');
        
        if (!file_exists($deployScriptPath)) {
            $msg = 'Script deploy.sh tidak ditemukan.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'log' => $msg]);
            }
            return redirect()->back()->with('error', $msg);
        }

        exec("bash " . escapeshellarg($deployScriptPath) . " 2>&1", $output, $return_var);

        $outputStr = implode("\n", $output);

        if ($return_var !== 0) {
            $msg = 'Deployment gagal (Kode: ' . $return_var . ').';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'log' => $msg . "\n\n" . $outputStr]);
            }
            return redirect()->back()->with('error', $msg . ' Output: ' . substr($outputStr, 0, 500));
        }

        $msg = 'Deployment berhasil dijalankan!';
        if ($request->ajax()) {
            return response()->json(['success' => true, 'log' => $outputStr]);
        }
        return redirect()->back()->with('success', $msg);
    }
}
