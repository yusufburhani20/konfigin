<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keunggulan;
use Illuminate\Http\Request;

class KeunggulanController extends Controller
{
    public function index()
    {
        $data = Keunggulan::orderBy('urutan')->get();
        return view('admin.keunggulan.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'icon'      => 'nullable|string|max:100',
            'urutan'    => 'nullable|integer',
        ]);

        Keunggulan::create([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi ?? '',
            'icon'      => $request->icon ?? 'fas fa-star',
            'urutan'    => $request->urutan ?? 0,
            'aktif'     => $request->has('aktif') ? 1 : 0,
        ]);

        return back()->with('success', 'Keunggulan berhasil ditambahkan.');
    }

    public function update(Request $request, Keunggulan $keunggulan)
    {
        $request->validate([
            'judul'     => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'icon'      => 'nullable|string|max:100',
            'urutan'    => 'nullable|integer',
        ]);

        $keunggulan->update([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi ?? '',
            'icon'      => $request->icon ?? 'fas fa-star',
            'urutan'    => $request->urutan ?? 0,
            'aktif'     => $request->has('aktif') ? 1 : 0,
        ]);

        return back()->with('success', 'Keunggulan berhasil diperbarui.');
    }

    public function destroy(Keunggulan $keunggulan)
    {
        $keunggulan->delete();
        return back()->with('success', 'Keunggulan berhasil dihapus.');
    }
}
