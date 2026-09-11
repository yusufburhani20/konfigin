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
<div class="modal" id="modal-form">
  <div class="modal-dialog">
    <div class="modal-header">
      <h3 class="modal-title" id="modal-title">Tambah Klien</h3>
      <button class="modal-close" onclick="closeModal('modal-form')"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <form id="form-data" action="/admin/clients" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="POST">
        
        <div class="form-group">
          <label class="form-label" for="name">Nama Klien / Perusahaan</label>
          <input type="text" id="name" name="name" class="form-input">
        </div>
        
        <div class="form-group">
          <label class="form-label" for="url">URL Website (Opsional)</label>
          <input type="text" id="url" name="url" class="form-input" placeholder="https://...">
        </div>

        <div class="form-group">
          <label class="form-label" for="logo">Logo <span id="logo-req" style="color:red">*</span></label>
          <input type="file" id="logo" name="logo" class="form-input" accept="image/*">
          <div class="form-help"><span id="logo-help" style="display:none;color:var(--accent)">Biarkan kosong jika tidak ingin mengubah logo saat edit.</span></div>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="urutan">Urutan Tampil</label>
          <input type="number" id="urutan" name="urutan" class="form-input" value="0">
        </div>
        
        <div class="form-group">
          <label class="form-label">
            <input type="checkbox" id="aktif" name="aktif" value="1" checked> Aktif (Tampilkan)
          </label>
        </div>

        <div style="margin-top:2rem; display:flex; justify-content:flex-end; gap:1rem">
          <button type="button" class="btn btn-outline" onclick="closeModal('modal-form')">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
function openFormModal(id = null, name = '', url = '', urutan = 0, aktif = true) {
  const methodInput = document.getElementById('form-method');
  const form = document.getElementById('form-data');
  const title = document.getElementById('modal-title');
  
  if(id) {
    title.innerText = 'Edit Klien';
    form.action = `/admin/clients/${id}`;
    methodInput.value = 'PUT';
    
    document.getElementById('name').value = name;
    document.getElementById('url').value = url;
    document.getElementById('urutan').value = urutan;
    document.getElementById('aktif').checked = aktif;
    
    document.getElementById('logo').removeAttribute('required');
    document.getElementById('logo-req').style.display = 'none';
    document.getElementById('logo-help').style.display = 'inline';
  } else {
    title.innerText = 'Tambah Klien';
    form.action = `/admin/clients`;
    methodInput.value = 'POST';
    
    form.reset();
    document.getElementById('urutan').value = 0;
    document.getElementById('aktif').checked = true;
    
    document.getElementById('logo').setAttribute('required', 'required');
    document.getElementById('logo-req').style.display = 'inline';
    document.getElementById('logo-help').style.display = 'none';
  }
  
  window.openModal('modal-form');
}
</script>
@endpush
