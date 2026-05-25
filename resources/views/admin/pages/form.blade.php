@extends('admin.layout')

@section('title', isset($page) ? 'Edit Halaman' : 'Tambah Halaman')
@section('page_title', isset($page) ? 'Edit Halaman: ' . $page->title : 'Buat Halaman Baru')
@section('page_subtitle', 'Gunakan editor untuk menyusun konten halaman')

@push('styles')
<!-- TinyMCE CDN loaded via script below -->
@endpush

@section('content')
<form method="POST" action="{{ isset($page) ? route('admin.pages.update', $page->id) : route('admin.pages.store') }}">
  @csrf
  @if(isset($page)) @method('PUT') @endif

  <div style="display:grid; grid-template-columns: 3fr 1fr; gap:1.5rem">
    
    <!-- Bagian Kiri (Editor Utama) -->
    <div style="display:flex; flex-direction:column; gap:1.5rem">
        <div class="card">
            <div class="card-body">
                <div class="form-group" style="margin-bottom: 0;">
                    <input type="text" id="title" name="title" class="form-input" style="font-size:1.5rem; padding:1rem; font-weight:700" value="{{ old('title', $page->title ?? '') }}" placeholder="Tambahkan Judul Halaman..." autocomplete="off" required>
                </div>
            </div>
        </div>

        <div class="card" style="flex:1">
            <div class="card-body" style="padding:0">
                <textarea id="content_editor" name="content">{!! old('content', $page->content ?? '') !!}</textarea>
            </div>
        </div>
    </div>

    <!-- Bagian Kanan (Sidebar Settings) -->
    <div style="display:flex; flex-direction:column; gap:1.5rem">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Terbitkan</h3></div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="status">Status Hak Akses Web</label>
                    <select id="status" name="status" class="form-input">
                        <option value="draft" {{ old('status', $page->status ?? '') == 'draft' ? 'selected' : '' }}>Sembunyikan (Draft)</option>
                        <option value="published" {{ old('status', $page->status ?? 'published') == 'published' ? 'selected' : '' }}>Tampilkan Publik (Publish)</option>
                    </select>
                </div>
                <div style="margin-top:2rem">
                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:0.75rem">
                        <i class="fas fa-save"></i> {{ isset($page) ? 'Perbarui Halaman' : 'Simpan Halaman' }}
                    </button>
                </div>
                
                @if(isset($page))
                <div style="margin-top:1rem; text-align:center;">
                   <a href="{{ url('/' . $page->slug) }}" target="_blank" style="font-size:0.85rem; color:var(--primary); text-decoration:underline">Lihat Hasil Halaman ini</a>
                </div>
                @endif
            </div>
        </div>
    </div>

  </div>
</form>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
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
            'removeformat | image link code | help',
        images_upload_url: '{{ route('admin.media.upload') }}',
        images_upload_credentials: true,
        content_style: 'body { font-family:Inter,sans-serif; font-size:16px }',
        skin: (window.matchMedia("(prefers-color-scheme: dark)").matches ? "oxide-dark" : "oxide"),
        content_css: (window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "default")
    });
</script>
@endpush
