<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Eservice;
use Illuminate\Http\Request;

class EserviceController extends Controller
{
    public function index()
    {
        $data = Eservice::orderBy('urutan')->get();
        return view('admin.eservice.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'url'       => 'required|string|max:500',
            'deskripsi' => 'nullable|string',
            'icon'      => 'nullable|string|max:100',
            'warna'     => 'nullable|string|max:50',
            'urutan'    => 'nullable|integer',
        ]);

        Eservice::create([
            'nama'      => $request->nama,
            'url'       => $request->url,
            'deskripsi' => $request->deskripsi ?? '',
            'icon'      => $request->icon ?? 'fas fa-globe',
            'warna'     => $request->warna ?? '#0d6efd',
            'urutan'    => $request->urutan ?? 0,
            'aktif'     => $request->has('aktif') ? 1 : 0,
        ]);

        return back()->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function update(Request $request, Eservice $eservice)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'url'       => 'required|string|max:500',
            'deskripsi' => 'nullable|string',
            'icon'      => 'nullable|string|max:100',
            'warna'     => 'nullable|string|max:50',
            'urutan'    => 'nullable|integer',
        ]);

        $eservice->update([
            'nama'      => $request->nama,
            'url'       => $request->url,
            'deskripsi' => $request->deskripsi ?? '',
            'icon'      => $request->icon ?? 'fas fa-globe',
            'warna'     => $request->warna ?? '#0d6efd',
            'urutan'    => $request->urutan ?? 0,
            'aktif'     => $request->has('aktif') ? 1 : 0,
        ]);

        return back()->with('success', 'Layanan berhasil diperbarui.');
    }

    public function destroy(Eservice $eservice)
    {
        $eservice->delete();
        return back()->with('success', 'Layanan berhasil dihapus.');
    }
}
