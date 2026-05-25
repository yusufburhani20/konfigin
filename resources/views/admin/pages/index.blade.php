@extends('admin.layout')

@section('title', 'Halaman Dinamis')
@section('page_title', 'Halaman Statis (Pages)')
@section('page_subtitle', 'Untuk Profile, Sejarah, Visi Misi yang sifatnya mandiri')

@section('content')
<div class="card">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <h2 class="card-title">Daftar Halaman</h2>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm">
      <i class="fas fa-plus"></i> Tambah Halaman
    </a>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Judul Halaman</th>
          <th>URL / Slug</th>
          <th width="100">Status</th>
          <th width="120">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data as $row)
        <tr>
          <td>
            <strong>{{ $row->title }}</strong>
            <div style="font-size:0.75rem; color:var(--text-secondary)">{{ $row->created_at->format('d M Y') }}</div>
          </td>
          <td><code>/{{ $row->slug }}</code></td>
          <td>
            @if($row->status === 'published')
              <span class="badge badge-success">Terbit</span>
            @else
              <span class="badge badge-secondary">Draft</span>
            @endif
          </td>
          <td>
            <div style="display:flex; gap:0.5rem">
              <a href="{{ url('/' . $row->slug) }}" target="_blank" class="btn btn-outline btn-sm" title="Lihat">
                <i class="fas fa-eye"></i>
              </a>
              <a href="{{ route('admin.pages.edit', $row->id) }}" class="btn btn-secondary btn-sm" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              <form method="POST" action="{{ route('admin.pages.destroy', $row->id) }}" onsubmit="return confirm('Hapus halaman dinamis ini?');" style="margin:0">
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
          <td colspan="4" style="text-align:center; padding:2rem">Belum ada halaman dinamis.</td>
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
