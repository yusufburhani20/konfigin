@extends('admin.layout')

@section('title', isset($post) ? 'Edit Post' : 'Tulis Post Baru')
@section('page_title', isset($post) ? 'Edit Artikel' : 'Tulis Artikel Baru')
@section('page_subtitle', 'Gunakan editor di bawah untuk menulis konten')

@push('styles')
<!-- TinyMCE CDN is loaded via script below, no extra CSS needed -->
@endpush

@section('content')
<form method="POST" action="{{ isset($post) ? route('admin.posts.update', $post->id) : route('admin.posts.store') }}" enctype="multipart/form-data">
  @csrf
  @if(isset($post)) @method('PUT') @endif

  <div style="display:grid; grid-template-columns: 3fr 1fr; gap:1.5rem">
    
    <!-- Bagian Kiri (Editor Utama) -->
    <div style="display:flex; flex-direction:column; gap:1.5rem">
        <div class="card">
            <div class="card-body">
                <div class="form-group" style="margin-bottom: 0;">
                    <input type="text" id="title" name="title" class="form-input" style="font-size:1.5rem; padding:1rem; font-weight:700" value="{{ old('title', $post->title ?? '') }}" placeholder="Tambahkan Judul Baru..." autocomplete="off" required>
                </div>
            </div>
        </div>

        <div class="card" style="flex:1">
            <div class="card-body" style="padding:0">
                <textarea id="content_editor" name="content">{!! old('content', $post->content ?? '') !!}</textarea>
            </div>
        </div>
    </div>

    <!-- Bagian Kanan (Sidebar Settings) -->
    <div style="display:flex; flex-direction:column; gap:1.5rem">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Terbitkan</h3></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="status">Status</label>
                    <select id="status" name="status" class="form-input">
                        <option value="draft" {{ old('status', $post->status ?? '') == 'draft' ? 'selected' : '' }}>Konsep (Draft)</option>
                        <option value="published" {{ old('status', $post->status ?? 'published') == 'published' ? 'selected' : '' }}>Terbitkan (Publish)</option>
                    </select>
                </div>
                <div style="margin-top:2rem">
                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:0.75rem">
                        <i class="fas fa-paper-plane"></i> {{ isset($post) ? 'Perbarui Post' : 'Simpan Post' }}
                    </button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="card-title">Kategori</h3></div>
            <div class="card-body">
                <div class="form-group" style="margin-bottom:0">
                    <select id="category_id" name="category_id" class="form-input">
                        <option value="">- Tanpa Kategori -</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h3 class="card-title">Galeri Foto & Thumbnail</h3></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="gallery">Pilih Foto (Bisa banyak)</label>
                    <input type="file" id="gallery" name="gallery[]" class="form-input" accept="image/*" multiple onchange="previewGallery(this)">
                    <div class="form-help">Pilih satu atau lebih gambar. Klik "Jadikan Utama" pada foto yang diinginkan.</div>
                </div>

                <!-- Hidden inputs for selection logic -->
                <input type="hidden" name="featured_index" id="featured_index" value="0">
                <input type="hidden" name="featured_image_url" id="featured_image_url" value="{{ $post->featured_image ?? '' }}">

                <!-- Preview Area -->
                <div id="gallery_preview" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 1.5rem;">
                    @if(isset($post))
                        @foreach($post->images as $img)
                            <div class="gallery-item-card" style="border: 1px solid {{ $post->featured_image == $img->image_path ? 'var(--primary)' : 'var(--border)' }}; padding: 5px; border-radius: 8px; position:relative;" id="img-card-{{ $img->id }}">
                                <img src="{{ asset($img->image_path) }}" style="width:100%; aspect-ratio:1/1; object-fit:cover; border-radius: 5px;">
                                <div style="margin-top: 5px; display: flex; flex-direction: column; gap: 5px;">
                                    <button type="button" class="btn btn-ghost btn-sm" style="width:100%; font-size: 0.7rem; justify-content:center; {{ $post->featured_image == $img->image_path ? 'background:var(--primary); color:white;' : '' }}" onclick="setExistingAsThumbnail('{{ $img->image_path }}', this)">
                                        {{ $post->featured_image == $img->image_path ? 'Thumbnail Aktif' : 'Jadikan Utama' }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

  </div>
</form>

<style>
    .gallery-item-card.is-featured {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 2px var(--primary-light);
    }
</style>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    function previewGallery(input) {
        const preview = document.getElementById('gallery_preview');
        // Keep existing if any, but add new previews
        const newFiles = Array.from(input.files);
        
        // Clear only the "newly" added items if we want a fresh preview, 
        // but typically user wants to see what they just picked.
        // For simplicity in this demo, we'll clear and show only current selection + existing ones
        const existingItems = preview.querySelectorAll('.gallery-item-card');
        
        newFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'gallery-item-card new-preview';
                div.style = 'border: 1px solid var(--border); padding: 5px; border-radius: 8px;';
                div.innerHTML = `
                    <img src="${e.target.result}" style="width:100%; aspect-ratio:1/1; object-fit:cover; border-radius: 5px;">
                    <div style="margin-top: 5px;">
                        <button type="button" class="btn btn-secondary btn-sm" style="width:100%; font-size: 0.7rem; justify-content:center;" onclick="setNewAsThumbnail(${index}, this)">Jadikan Utama</button>
                    </div>
                `;
                preview.appendChild(div);
                
                // Default first one as thumbnail if none selected and it's a new post
                if (index === 0 && !document.getElementById('featured_image_url').value) {
                    setNewAsThumbnail(0, div.querySelector('button'));
                }
            }
            reader.readAsDataURL(file);
        });
    }

    function setNewAsThumbnail(index, btn) {
        // Clear other featured states
        document.querySelectorAll('.gallery-item-card button').forEach(b => {
             b.classList.remove('btn-primary');
             b.classList.add('btn-secondary');
             b.innerText = 'Jadikan Utama';
             b.parentElement.parentElement.style.borderColor = 'var(--border)';
        });
        
        // Set this one
        document.getElementById('featured_index').value = index;
        document.getElementById('featured_image_url').value = ''; // Clear existing URL selection
        
        btn.classList.remove('btn-secondary');
        btn.classList.add('btn-primary');
        btn.innerText = 'Thumbnail Dipilih';
        btn.parentElement.parentElement.style.borderColor = 'var(--primary)';
    }

    function setExistingAsThumbnail(path, btn) {
        // Clear other featured states
        document.querySelectorAll('.gallery-item-card button').forEach(b => {
             b.style.background = '';
             b.style.color = '';
             b.innerText = 'Jadikan Utama';
             b.parentElement.parentElement.style.borderColor = 'var(--border)';
        });

        document.getElementById('featured_image_url').value = path;
        document.getElementById('featured_index').value = -1; // Ignore index
        
        btn.style.background = 'var(--primary)';
        btn.style.color = 'white';
        btn.innerText = 'Thumbnail Aktif';
        btn.parentElement.parentElement.style.borderColor = 'var(--primary)';
    }
</script>
<script>
    tinymce.init({
        selector: '#content_editor',
        height: 600,
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | image link | help',
        images_upload_url: '{{ route('admin.media.upload') }}',
        images_upload_credentials: true,
        content_style: 'body { font-family:Inter,sans-serif; font-size:16px }',
        skin: (window.matchMedia("(prefers-color-scheme: dark)").matches ? "oxide-dark" : "oxide"),
        content_css: (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "default")
    });
</script>
@endpush
