<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 'published')->first();
        if (!$page) {
            abort(404);
        }
        
        return view('page', compact('page'));
    }
}
