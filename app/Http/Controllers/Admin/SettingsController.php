<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::allAsArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_title'         => 'nullable|string|max:200',
            'hero_subtitle'      => 'nullable|string|max:500',
            'profil_text'        => 'nullable|string',
            'instagram_username' => 'nullable|string|max:100',
            'site_name'          => 'nullable|string|max:100',
            'site_tagline'       => 'nullable|string|max:200',
            'site_logo'          => 'nullable|image|max:2048',
            'theme_primary_color'   => 'nullable|string|max:20',
            'theme_secondary_color' => 'nullable|string|max:20',
            'theme_border_radius'   => 'nullable|string|max:20',
            'client_logos'          => 'nullable|string',
            'tech_stacks'           => 'nullable|string',
            'stat_about_1_num'      => 'nullable|string|max:50',
            'stat_about_1_lbl'      => 'nullable|string|max:150',
            'stat_about_2_num'      => 'nullable|string|max:50',
            'stat_about_2_lbl'      => 'nullable|string|max:150',
            'stat_about_3_num'      => 'nullable|string|max:50',
            'stat_about_3_lbl'      => 'nullable|string|max:150',
            'stat_keunggulan_1_num' => 'nullable|string|max:50',
            'stat_keunggulan_1_lbl' => 'nullable|string|max:150',
            'stat_keunggulan_2_num' => 'nullable|string|max:50',
            'stat_keunggulan_2_lbl' => 'nullable|string|max:150',
            'stat_keunggulan_3_num' => 'nullable|string|max:50',
            'stat_keunggulan_3_lbl' => 'nullable|string|max:150',
            'comparison_rows'       => 'nullable|string',
        ]);

        $keys = [
            'hero_title', 'hero_subtitle', 'profil_text', 'instagram_username', 
            'site_name', 'site_tagline', 'theme_primary_color', 
            'theme_secondary_color', 'theme_border_radius',
            'client_logos', 'tech_stacks',
            'stat_about_1_num', 'stat_about_1_lbl',
            'stat_about_2_num', 'stat_about_2_lbl',
            'stat_about_3_num', 'stat_about_3_lbl',
            'stat_keunggulan_1_num', 'stat_keunggulan_1_lbl',
            'stat_keunggulan_2_num', 'stat_keunggulan_2_lbl',
            'stat_keunggulan_3_num', 'stat_keunggulan_3_lbl',
            'comparison_rows'
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key) ?? '');
            }
        }

        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('uploads', 'public');
            Setting::set('site_logo', Storage::url($path));
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
