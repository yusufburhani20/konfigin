@extends('admin.layout')

@section('title', 'Klien & Partner')
@section('page_title', 'Klien & Partner')
@section('page_subtitle', 'Kelola logo klien dan partner untuk ditampilkan di beranda')

@section('content')
<div class="card">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <h2 class="card-title">Daftar Klien & Partner</h2>
    <button class="btn btn-primary btn-sm" onclick="openFormModal()">
      <i class="fas fa-plus"></i> Tambah Klien
    </button>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th width="80">Urutan</th>
          <th width="120">Logo</th>
          <th>Nama Klien</th>
          <th>URL Website</th>
          <th width="100">Status</th>
          <th width="150">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data as $item)
        <tr>
          <td>{{ $item->urutan }}</td>
          <td>
            @if(!empty($item->logo_url) && $item->logo_url !== '#')
              <img src="{{ asset($item->logo_url) }}" alt="Logo" style="max-width: 80px; max-height: 50px; object-fit: contain; background: #f8f9fa; padding: 4px; border-radius: 4px;">
            @else
              <span style="color:#999; font-size:12px;">Tidak ada</span>
            @endif
          </td>
          <td>{{ $item->name ?? '-' }}</td>
          <td>
            @if(!empty($item->url) && $item->url !== '#')
              <a href="{{ $item->url }}" target="_blank"><i class="fas fa-external-link-alt"></i> Kunjungi</a>
            @else
              -
            @endif
          </td>
          <td>
            @if($item->aktif)
              <span class="badge" style="background:var(--success); color:white; padding:4px 8px; border-radius:12px; font-size:12px;">Aktif</span>
            @else
              <span class="badge" style="background:var(--gray); color:white; padding:4px 8px; border-radius:12px; font-size:12px;">Draft</span>
            @endif
          </td>
          <td>
            <div style="display:flex; gap:8px;">
              <button class="btn btn-sm" style="background:var(--warning); color:white; padding:6px 10px;" 
                onclick="openFormModal({{ $item->id }}, '{{ addslashes($item->name ?? '') }}', '{{ addslashes($item->url ?? '') }}', {{ $item->urutan }}, {{ $item->aktif ? 'true' : 'false' }})">
                <i class="fas fa-edit"></i>
              </button>
              <form action="{{ route('admin.clients.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus klien ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm" style="background:var(--danger); color:white; padding:6px 10px;">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" style="text-align:center; padding:2rem; color:var(--gray);">
            Belum ada data klien. Silakan tambahkan baru.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Form -->
<div id="formModal" class="modal">
  <div class="modal-content" style="max-width: 500px;">
    <div class="modal-header">
      <h3 id="modalTitle">Tambah Klien</h3>
      <button class="modal-close" onclick="closeFormModal()">&times;</button>
    </div>
    <form id="clientForm" action="/admin/clients" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="_method" id="formMethod" value="POST">
      
      <div class="form-group">
        <label class="form-label" for="name">Nama Klien / Perusahaan</label>
        <input type="text" id="name" name="name" class="form-input">
      </div>
      
      <div class="form-group">
        <label class="form-label" for="url">URL Website (Opsional)</label>
        <input type="text" id="url" name="url" class="form-input" placeholder="https://...">
      </div>

      <div class="form-group">
        <label class="form-label" for="logo">Logo</label>
        <input type="file" id="logo" name="logo" class="form-input" accept="image/*">
        <div class="form-help">Biarkan kosong jika tidak ingin mengubah logo saat edit.</div>
      </div>
      
      <div class="form-group">
        <label class="form-label" for="urutan">Urutan Tampil</label>
        <input type="number" id="urutan" name="urutan" class="form-input" value="0">
      </div>
      
      <div class="form-group" style="display:flex; align-items:center; gap:8px;">
        <input type="checkbox" id="aktif" name="aktif" value="1" checked>
        <label for="aktif" style="margin:0;">Tampilkan Klien</label>
      </div>

      <div style="margin-top: 1.5rem; display:flex; justify-content:flex-end; gap:10px;">
        <button type="button" class="btn" style="background:#e2e8f0; color:#475569;" onclick="closeFormModal()">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </form>
  </div>
</div>

<style>
/* Simple Modal CSS */
.modal {
  display: none;
  position: fixed !important;
  z-index: 9999 !important;
  left: 0 !important;
  top: 0 !important;
  width: 100vw !important;
  height: 100vh !important;
  overflow: auto;
  background-color: rgba(0,0,0,0.7);
  align-items: center;
  justify-content: center;
}
.modal.show {
  display: flex;
}
.modal-content {
  background-color: #1e293b; /* Dark background to match dashboard */
  color: #f1f5f9;
  margin: auto;
  padding: 1.5rem;
  border-radius: 8px;
  width: 90%;
  max-width: 500px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.5);
  border: 1px solid #334155;
}
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
  border-bottom: 1px solid #334155;
  padding-bottom: 1rem;
}
.modal-header h3 {
  margin: 0;
  font-size: 1.25rem;
  color: #f8fafc;
}
.modal-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #94a3b8;
}
.modal-close:hover {
  color: #f1f5f9;
}
/* Force inputs to be dark in modal */
.modal-content .form-input {
  background-color: #0f172a !important;
  color: #f8fafc !important;
  border: 1px solid #334155 !important;
}
.modal-content .form-label {
  color: #cbd5e1 !important;
}
</style>

<script>
function openFormModal(id = null, name = '', url = '', urutan = 0, aktif = true) {
  const modal = document.getElementById('formModal');
  const form = document.getElementById('clientForm');
  const methodInput = document.getElementById('formMethod');
  const title = document.getElementById('modalTitle');
  
  if(id) {
    title.innerText = 'Edit Klien';
    form.action = `/admin/clients/${id}`;
    methodInput.value = 'PUT';
    
    document.getElementById('name').value = name;
    document.getElementById('url').value = url;
    document.getElementById('urutan').value = urutan;
    document.getElementById('aktif').checked = aktif;
    
    // Logo is not required on edit
    document.getElementById('logo').removeAttribute('required');
  } else {
    title.innerText = 'Tambah Klien';
    form.action = `/admin/clients`;
    methodInput.value = 'POST';
    
    form.reset();
    document.getElementById('urutan').value = 0;
    document.getElementById('aktif').checked = true;
    
    // Logo is required on create
    document.getElementById('logo').setAttribute('required', 'required');
  }
  
  modal.classList.add('show');
}

function closeFormModal() {
  const modal = document.getElementById('formModal');
  modal.classList.remove('show');
}
</script>
@endsection
