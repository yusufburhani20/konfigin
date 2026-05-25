<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $data = Galeri::orderBy('urutan')->get();
        return view('admin.galeri.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'         => 'nullable|string|max:200',
            'instagram_url' => 'nullable|string|max:500',
            'urutan'        => 'nullable|integer',
            'foto'          => 'nullable|image|max:5120',
        ]);

        $foto_url = '#';

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('uploads', 'public');
            $foto_url = Storage::url($path);
        }

        Galeri::create([
            'judul'         => $request->judul ?? '',
            'foto_url'      => $foto_url,
            'instagram_url' => $request->instagram_url ?? '#',
            'urutan'        => $request->urutan ?? 0,
            'aktif'         => $request->has('aktif') ? 1 : 0,
        ]);

        return back()->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function update(Request $request, Galeri $galeri)
    {
        $request->validate([
            'judul'         => 'nullable|string|max:200',
            'instagram_url' => 'nullable|string|max:500',
            'urutan'        => 'nullable|integer',
            'foto'          => 'nullable|image|max:5120',
        ]);

        $data = [
            'judul'         => $request->judul ?? '',
            'instagram_url' => $request->instagram_url ?? '#',
            'urutan'        => $request->urutan ?? 0,
            'aktif'         => $request->has('aktif') ? 1 : 0,
        ];

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('uploads', 'public');
            $data['foto_url'] = Storage::url($path);
        }

        $galeri->update($data);

        return back()->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri)
    {
        $galeri->delete();
        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }
}
