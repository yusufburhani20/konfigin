<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kurikulum;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    public function index()
    {
        $data = Kurikulum::orderBy('urutan')->get();
        return view('admin.kurikulum.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_mapel'  => 'required|string|max:200',
            'modul_url'   => 'nullable|string|max:500',
            'roadmap_url' => 'nullable|string|max:500',
            'urutan'      => 'nullable|integer',
            'aktif'       => 'nullable|boolean',
            'harga'       => 'nullable|string|max:100',
            'fitur'       => 'nullable|string',
            'badge'       => 'nullable|string|max:50',
        ]);
        $validated['modul_url']   = $validated['modul_url'] ?? '#';
        $validated['roadmap_url'] = $validated['roadmap_url'] ?? '#';
        $validated['urutan']      = $validated['urutan'] ?? 0;
        $validated['aktif']       = $request->has('aktif') ? 1 : 0;

        Kurikulum::create($validated);

        return back()->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function update(Request $request, Kurikulum $kurikulum)
    {
        $validated = $request->validate([
            'nama_mapel'  => 'required|string|max:200',
            'modul_url'   => 'nullable|string|max:500',
            'roadmap_url' => 'nullable|string|max:500',
            'urutan'      => 'nullable|integer',
            'aktif'       => 'nullable|boolean',
            'harga'       => 'nullable|string|max:100',
            'fitur'       => 'nullable|string',
            'badge'       => 'nullable|string|max:50',
        ]);
        $validated['modul_url']   = $validated['modul_url'] ?? '#';
        $validated['roadmap_url'] = $validated['roadmap_url'] ?? '#';
        $validated['urutan']      = $validated['urutan'] ?? 0;
        $validated['aktif']       = $request->has('aktif') ? 1 : 0;

        $kurikulum->update($validated);

        return back()->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Kurikulum $kurikulum)
    {
        $kurikulum->delete();
        return back()->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
