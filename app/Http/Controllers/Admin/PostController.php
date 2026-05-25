<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $query = Post::with('category', 'author')->latest();
        
        // If author, only see own posts
        if (auth()->user()->role === 'author') {
            $query->where('user_id', auth()->id());
        }

        $data = $query->paginate(20);
        return view('admin.posts.index', compact('data'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.form', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'          => 'required|string|max:200',
            'category_id'    => 'nullable|integer',
            'content'        => 'required|string',
            'status'         => 'required|in:draft,published',
            'gallery'        => 'nullable|array',
            'gallery.*'      => 'image|max:5120',
        ]);

        $post = Post::create([
            'user_id'        => auth()->id(),
            'category_id'    => $request->category_id,
            'title'          => $request->title,
            'slug'           => Str::slug($request->title) . '-' . time(),
            'excerpt'        => Str::limit(strip_tags($request->content), 150),
            'content'        => $request->content,
            'status'         => $request->status,
        ]);

        // Handle Gallery Uploads
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $file) {
                $path = $file->store('uploads/posts', 'public');
                $url = Storage::url($path);
                
                $img = PostImage::create([
                    'post_id'    => $post->id,
                    'image_path' => $url
                ]);

                // If this index is marked as featured (default 0 if not specified)
                if ($index == $request->input('featured_index', 0)) {
                    $post->update(['featured_image' => $url]);
                }
            }
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil ditambahkan.');
    }

    public function edit(Post $post)
    {
        if (auth()->user()->role === 'author' && $post->user_id !== auth()->id()) {
            abort(403);
        }
        $categories = Category::all();
        return view('admin.posts.form', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        if (auth()->user()->role === 'author' && $post->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'title'          => 'required|string|max:200',
            'category_id'    => 'nullable|integer',
            'content'        => 'required|string',
            'status'         => 'required|in:draft,published',
            'gallery'        => 'nullable|array',
            'gallery.*'      => 'image|max:5120',
        ]);

        $post->update([
            'category_id'    => $request->category_id,
            'title'          => $request->title,
            'content'        => $request->content,
            'excerpt'        => Str::limit(strip_tags($request->content), 150),
            'status'         => $request->status,
        ]);

        // Handle New Gallery Uploads
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $path = $file->store('uploads/posts', 'public');
                $url = Storage::url($path);
                
                PostImage::create([
                    'post_id'    => $post->id,
                    'image_path' => $url
                ]);
            }
        }

        // Set Featured Image from existing or new
        if ($request->filled('featured_image_url')) {
            $post->update(['featured_image' => $request->featured_image_url]);
        }

        return redirect()->route('admin.posts.index')->with('success', 'Post berhasil diperbarui.');
    }

    public function destroyImage(PostImage $image)
    {
        // Simple delete for now
        $image->delete();
        return back()->with('success', 'Gambar galeri berhasil dihapus.');
    }

    public function destroy(Post $post)
    {
        if (auth()->user()->role === 'author' && $post->user_id !== auth()->id()) {
            abort(403);
        }
        $post->delete();
        return back()->with('success', 'Post berhasil dihapus.');
    }
}
