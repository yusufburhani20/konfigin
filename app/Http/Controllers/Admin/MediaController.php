<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Upload handler for TinyMCE editor
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:10240' // max 10MB
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('uploads/media', 'public');
            $url = Storage::url($path);
            
            return response()->json(['location' => $url]);
        }
        
        return response()->json(['error' => 'Gagal mengupload gambar'], 400);
    }
}
