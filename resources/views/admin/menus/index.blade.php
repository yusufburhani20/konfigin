@extends('admin.layout')

@section('title', 'Menu Navigasi')
@section('page_title', 'Menu Navigasi Website')
@section('page_subtitle', 'Kelola daftar menu yang tampil di header website')

@section('content')
<div class="card">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <h2 class="card-title">Daftar Menu Navigasi</h2>
    <button class="btn btn-primary btn-sm" onclick="openFormModal()">
      <i class="fas fa-plus"></i> Tambah Menu
    </button>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Urutan</th>
          <th>Nama Menu</th>
          <th>Tautan (URL)</th>
          <th>Ikon Mobile</th>
          <th>Status</th>
          <th width="150">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($menus as $row)
        <tr>
          <td>{{ $row->order }}</td>
          <td><strong>{{ $row->name }}</strong></td>
          <td><code>{{ $row->url }}</code></td>
          <td>
            <div style="display:flex; align-items:center; gap:0.5rem">
              <span class="material-symbols-outlined" style="font-size:18px;">{{ $row->icon }}</span>
              <small>{{ $row->icon }}</small>
            </div>
          </td>
          <td>
            @if($row->is_active)
              <span class="badge badge-success" style="background:#10b981;color:white;padding:2px 8px;border-radius:12px;font-size:12px;">Aktif</span>
            @else
              <span class="badge badge-error" style="background:#ef4444;color:white;padding:2px 8px;border-radius:12px;font-size:12px;">Nonaktif</span>
            @endif
          </td>
          <td>
            <div style="display:flex; gap:0.5rem">
              <button class="btn btn-secondary btn-sm" onclick="editData({{ json_encode($row) }})" title="Edit">
                <i class="fas fa-edit"></i>
              </button>
              <form method="POST" action="{{ route('admin.menus.destroy', $row->id) }}" onsubmit="return confirm('Yakin ingin menghapus menu ini?');" style="margin:0">
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
          <td colspan="6" style="text-align:center; padding:2rem">Belum ada data menu navigasi.</td>
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
      <h3 class="modal-title" id="modal-title">Tambah / Edit Menu</h3>
      <button type="button" class="modal-close" onclick="closeModal('modal-form')"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <form id="form-data" method="POST" action="">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="POST">
        
        <div class="form-group">
          <label class="form-label" for="name">Nama Menu</label>
          <input type="text" id="name" name="name" class="form-input" placeholder="Contoh: Layanan" required>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="url">Tautan (URL)</label>
          <input type="text" id="url" name="url" class="form-input" placeholder="Contoh: #layanan-utama atau /blog" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="icon">Ikon Menu Mobile</label>
          <input type="text" id="icon" name="icon" class="form-input" placeholder="Contoh: apps" value="link">
          <div class="form-help">Gunakan nama ikon dari <a href="https://fonts.google.com/icons?selected=Material+Symbols+Outlined" target="_blank">Google Material Symbols</a>.</div>
        </div>

        <div class="form-group">
          <label class="form-label" for="order">Urutan Tampil (Order)</label>
          <input type="number" id="order" name="order" class="form-input" placeholder="0" required>
        </div>

        <div class="form-group" style="margin-top:1rem;">
          <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
            <input type="checkbox" name="is_active" id="is_active" value="1" checked>
            <span>Tampilkan di menu? (Aktif)</span>
          </label>
        </div>
        
        <div style="margin-top:2rem; display:flex; justify-content:flex-end; gap:1rem">
          <button type="button" class="btn btn-outline" onclick="closeModal('modal-form')">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Menu</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function openFormModal() {
    document.getElementById('modal-title').innerText = 'Tambah Menu Baru';
    document.getElementById('form-data').action = '{{ route('admin.menus.store') }}';
    document.getElementById('form-method').value = 'POST';
    
    document.getElementById('name').value = '';
    document.getElementById('url').value = '';
    document.getElementById('icon').value = 'link';
    document.getElementById('order').value = '0';
    document.getElementById('is_active').checked = true;
    
    window.openModal('modal-form');
}

function editData(data) {
    document.getElementById('modal-title').innerText = 'Edit Menu';
    document.getElementById('form-data').action = '/admin/menus/' + data.id;
    document.getElementById('form-method').value = 'PUT';
    
    document.getElementById('name').value = data.name;
    document.getElementById('url').value = data.url;
    document.getElementById('icon').value = data.icon || 'link';
    document.getElementById('order').value = data.order || 0;
    document.getElementById('is_active').checked = data.is_active ? true : false;
    
    window.openModal('modal-form');
}
</script>
@endpush