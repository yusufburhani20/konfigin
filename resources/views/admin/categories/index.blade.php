@extends('admin.layout')

@section('title', 'Kategori Berita')
@section('page_title', 'Kategori Post/Berita')
@section('page_subtitle', 'Kelompokkan berita atau artikel yang ditulis')

@section('content')
<div class="card">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <h2 class="card-title">Daftar Kategori</h2>
    <button class="btn btn-primary btn-sm" onclick="openFormModal()">
      <i class="fas fa-plus"></i> Tambah Kategori
    </button>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Nama Kategori</th>
          <th>Slug</th>
          <th>Deskripsi</th>
          <th width="150">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data as $row)
        <tr>
          <td><strong>{{ $row->name }}</strong></td>
          <td><code>{{ $row->slug }}</code></td>
          <td>{{ Str::limit($row->description, 50) }}</td>
          <td>
            <div style="display:flex; gap:0.5rem">
              <button class="btn btn-secondary btn-sm" onclick='editData(@json($row))' title="Edit">
                <i class="fas fa-edit"></i>
              </button>
              <form method="POST" action="{{ route('admin.categories.destroy', $row->id) }}" onsubmit="return confirm('Menghapus kategori akan mengosongkan kategori dari post terkait. Lanjut?');" style="margin:0">
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
          <td colspan="4" style="text-align:center; padding:2rem">Belum ada data kategori.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Add/Edit -->
<div class="modal-overlay" id="modal-form">
  <div class="modal">
    <div class="modal-header">
      <h3 class="modal-title" id="modal-title">Tambah / Edit Kategori</h3>
      <button type="button" class="modal-close" onclick="closeModal('modal-form')"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <form id="form-data" method="POST" action="">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="POST">
        
        <div class="form-group">
          <label class="form-label" for="name">Nama Kategori</label>
          <input type="text" id="name" name="name" class="form-input" required>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="description">Deskripsi Singkat</label>
          <textarea id="description" name="description" class="form-input" rows="3"></textarea>
        </div>
        
        <div style="margin-top:2rem; display:flex; justify-content:flex-end; gap:1rem">
          <button type="button" class="btn btn-outline" onclick="closeModal('modal-form')">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function openFormModal() {
    document.getElementById('modal-title').innerText = 'Tambah Kategori Baru';
    document.getElementById('form-data').action = '{{ route('admin.categories.store') }}';
    document.getElementById('form-method').value = 'POST';
    
    document.getElementById('name').value = '';
    document.getElementById('description').value = '';
    
    window.openModal('modal-form');
}

function editData(data) {
    document.getElementById('modal-title').innerText = 'Edit Kategori';
    document.getElementById('form-data').action = '/admin/categories/' + data.id;
    document.getElementById('form-method').value = 'PUT';
    
    document.getElementById('name').value = data.name;
    document.getElementById('description').value = data.description || '';
    
    window.openModal('modal-form');
}
</script>
@endpush
