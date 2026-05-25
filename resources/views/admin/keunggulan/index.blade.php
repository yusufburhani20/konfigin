@extends('admin.layout')

@section('title', 'Keunggulan Jurusan')
@section('page_title', 'Keunggulan Jurusan')
@section('page_subtitle', 'Tampilkan poin-poin alasan memilih TJKT')

@section('content')
<div class="card">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <h2 class="card-title">Daftar Keunggulan</h2>
    <button class="btn btn-primary btn-sm" onclick="openFormModal()">
      <i class="fas fa-plus"></i> Tambah Keunggulan
    </button>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th width="80">Urutan</th>
          <th width="80">Icon</th>
          <th>Judul Poin & Deskripsi</th>
          <th width="100">Status</th>
          <th width="150">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data as $row)
        <tr>
          <td style="text-align:center">{{ $row->urutan }}</td>
          <td style="text-align:center; font-size:1.5rem; color:var(--primary)">
            <i class="{{ $row->icon }}"></i>
          </td>
          <td>
            <strong>{{ $row->judul }}</strong>
            <div style="font-size:0.85rem; color:var(--text-secondary); margin-top:4px">{{ $row->deskripsi }}</div>
          </td>
          <td>
            @if($row->aktif)
              <span class="badge badge-success">Aktif</span>
            @else
              <span class="badge badge-danger">Tidak Aktif</span>
            @endif
          </td>
          <td>
            <div style="display:flex; gap:0.5rem">
              <button class="btn btn-secondary btn-sm" onclick='editData(@json($row))' title="Edit">
                <i class="fas fa-edit"></i>
              </button>
              <form method="POST" action="{{ route('admin.keunggulan.destroy', $row->id) }}" onsubmit="return confirm('Yakin ingin menghapus item ini?');" style="margin:0">
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
          <td colspan="5" style="text-align:center; padding:2rem">Belum ada data keunggulan.</td>
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
      <h3 class="modal-title" id="modal-title">Tambah / Edit Keunggulan</h3>
      <button type="button" class="modal-close" onclick="closeModal('modal-form')"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <form id="form-data" method="POST" action="">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="POST">
        
        <div class="form-group">
          <label class="form-label" for="judul">Judul/Poin Keunggulan</label>
          <input type="text" id="judul" name="judul" class="form-input" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="deskripsi">Deskripsi Detail</label>
          <textarea id="deskripsi" name="deskripsi" class="form-input" rows="4"></textarea>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="icon">Icon Class (FontAwesome)</label>
          <input type="text" id="icon" name="icon" class="form-input" value="fas fa-star">
          <div class="form-help">Cari icon di fontawesome.com/search (v6). Contoh: <code>fas fa-star</code></div>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="urutan">Urutan Tampil</label>
          <input type="number" id="urutan" name="urutan" class="form-input" value="0" required>
        </div>
        
        <div class="form-group">
          <label class="form-label">
            <input type="checkbox" id="aktif" name="aktif" value="1" checked> Aktif (Tampilkan)
          </label>
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
    document.getElementById('modal-title').innerText = 'Tambah Keunggulan';
    document.getElementById('form-data').action = '{{ route('admin.keunggulan.store') }}';
    document.getElementById('form-method').value = 'POST';
    
    document.getElementById('judul').value = '';
    document.getElementById('deskripsi').value = '';
    document.getElementById('icon').value = 'fas fa-star';
    document.getElementById('urutan').value = '0';
    document.getElementById('aktif').checked = true;
    
    window.openModal('modal-form');
}

function editData(data) {
    document.getElementById('modal-title').innerText = 'Edit Keunggulan';
    document.getElementById('form-data').action = '/admin/keunggulan/' + data.id;
    document.getElementById('form-method').value = 'PUT';
    
    document.getElementById('judul').value = data.judul;
    document.getElementById('deskripsi').value = data.deskripsi;
    document.getElementById('icon').value = data.icon;
    document.getElementById('urutan').value = data.urutan;
    document.getElementById('aktif').checked = data.aktif ? true : false;
    
    window.openModal('modal-form');
}
</script>
@endpush
