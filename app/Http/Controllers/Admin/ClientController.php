<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $data = Client::orderBy('urutan')->get();
        return view('admin.clients.index', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'nullable|string|max:200',
            'url'    => 'nullable|string|max:500',
            'urutan' => 'nullable|integer',
            'logo'   => 'required|image|max:5120',
        ]);

        $logo_url = '';

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('uploads', 'public');
            $logo_url = Storage::url($path);
        }

        Client::create([
            'name'     => $request->name ?? '',
            'logo_url' => $logo_url,
            'url'      => $request->url ?? '#',
            'urutan'   => $request->filled('urutan') ? (int)$request->urutan : 0,
            'aktif'    => $request->has('aktif') ? 1 : 0,
        ]);

        return back()->with('success', 'Client berhasil ditambahkan.');
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name'   => 'nullable|string|max:200',
            'url'    => 'nullable|string|max:500',
            'urutan' => 'nullable|integer',
            'logo'   => 'nullable|image|max:5120',
        ]);

        $data = [
            'name'   => $request->name ?? '',
            'url'    => $request->url ?? '#',
            'urutan' => $request->filled('urutan') ? (int)$request->urutan : 0,
            'aktif'  => $request->has('aktif') ? 1 : 0,
        ];

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('uploads', 'public');
            $data['logo_url'] = Storage::url($path);
        }

        $client->update($data);

        return back()->with('success', 'Client berhasil diperbarui.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return back()->with('success', 'Client berhasil dihapus.');
    }
}
