@extends('admin.layout')

@section('title', 'Semua Post')
@section('page_title', 'Daftar Artikel / Post')
@section('page_subtitle', 'Manajemen artikel dan berita website')

@section('content')
<div class="card">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <h2 class="card-title">Semua Artikel</h2>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
      <i class="fas fa-plus"></i> Tulis Baru
    </a>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th width="80">Image</th>
          <th>Judul Post</th>
          <th>Penulis</th>
          <th>Kategori</th>
          <th width="100">Status</th>
          <th width="120">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data as $row)
        <tr>
          <td>
            @if($row->featured_image)
            <img src="{{ asset($row->featured_image) }}" alt="Img" style="width:60px; height:60px; object-fit:cover; border-radius:6px">
            @else
            <div style="width:60px; height:60px; background:var(--border); border-radius:6px; display:flex; align-items:center; justify-content:center; color:var(--text-secondary)"><i class="fas fa-image"></i></div>
            @endif
          </td>
          <td>
            <strong>{{ $row->title }}</strong>
            <div style="font-size:0.75rem; color:var(--text-secondary)">{{ $row->created_at->format('d M Y, H:i') }}</div>
          </td>
          <td>{{ $row->author->nama ?? 'Unknown' }}</td>
          <td>
            @if($row->category)
              <span class="badge" style="background:var(--sidebar-hover)">{{ $row->category->name }}</span>
            @else
              -
            @endif
          </td>
          <td>
            @if($row->status === 'published')
              <span class="badge badge-success">Terbit</span>
            @else
              <span class="badge badge-secondary">Draft</span>
            @endif
          </td>
          <td>
            <div style="display:flex; gap:0.5rem">
              <a href="{{ route('admin.posts.edit', $row->id) }}" class="btn btn-secondary btn-sm" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              <form method="POST" action="{{ route('admin.posts.destroy', $row->id) }}" onsubmit="return confirm('Yakin ingin menghapus artikel ini permanen?');" style="margin:0">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align:center; padding:2rem">Belum ada artikel yang ditulis.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    <div style="padding: 1rem 1.5rem">
        {{ $data->links('pagination::bootstrap-4') }}
    </div>
  </div>
</div>
@endsection
