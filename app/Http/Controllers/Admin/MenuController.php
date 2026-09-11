<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = \App\Models\Menu::ordered()->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'url'       => 'required|string|max:255',
            'icon'      => 'nullable|string|max:255',
            'order'     => 'required|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        if (empty($validated['icon'])) {
            $validated['icon'] = 'link';
        }

        \App\Models\Menu::create($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(\App\Models\Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    public function update(Request $request, \App\Models\Menu $menu)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'url'       => 'required|string|max:255',
            'icon'      => 'nullable|string|max:255',
            'order'     => 'required|integer',
        ]);

        $validated['is_active'] = $request->has('is_active');
        if (empty($validated['icon'])) {
            $validated['icon'] = 'link';
        }

        $menu->update($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(\App\Models\Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil dihapus.');
    }
