<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function edit()
    {
        $kontak = Kontak::query()->first() ?? new Kontak();
        return view('admin.kontak.edit', compact('kontak'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'email'      => 'nullable|email|max:200',
            'whatsapp'   => 'nullable|string|max:50',
            'website'    => 'nullable|string|max:200',
            'alamat'     => 'nullable|string',
            'maps_embed' => 'nullable|string',
        ]);

        $kontak = Kontak::query()->first();
        if ($kontak) {
            $kontak->update($request->only(['email', 'whatsapp', 'website', 'alamat', 'maps_embed']));
        } else {
            Kontak::create($request->only(['email', 'whatsapp', 'website', 'alamat', 'maps_embed']));
        }

        return back()->with('success', 'Informasi kontak berhasil diperbarui.');
    }
}
