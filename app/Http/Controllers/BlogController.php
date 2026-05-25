<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Setting;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with('category', 'author', 'images')
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        $categories = Category::withCount('posts')->get();
        $site_settings = Setting::allAsArray();

        return view('blog.index', [
            'posts'      => $posts,
            'categories' => $categories,
            'site_name'  => $site_settings['site_name'] ?? 'Konfigin IT Solutions',
            'site_logo'  => $site_settings['site_logo'] ?? null,
            'title'      => 'Berita & Artikel'
        ]);
    }

    public function show($slug)
    {
        $post = Post::with('category', 'author', 'images')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $categories = Category::withCount('posts')->get();
        $site_settings = Setting::allAsArray();
        $recent_posts = Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->latest()
            ->take(5)
            ->get();

        return view('blog.show', [
            'post'         => $post,
            'categories'   => $categories,
            'recent_posts' => $recent_posts,
            'site_name'    => $site_settings['site_name'] ?? 'Konfigin IT Solutions',
            'site_logo'    => $site_settings['site_logo'] ?? null,
            'title'        => $post->title
        ]);
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $posts = Post::with('category', 'author', 'images')
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->latest()
            ->paginate(12);

        $categories = Category::withCount('posts')->get();
        $site_settings = Setting::allAsArray();

        return view('blog.index', [
            'posts'         => $posts,
            'categories'    => $categories,
            'current_cat'   => $category,
            'site_name'     => $site_settings['site_name'] ?? 'Konfigin IT Solutions',
            'site_logo'     => $site_settings['site_logo'] ?? null,
            'title'         => 'Kategori: ' . $category->name
        ]);
    }
}
