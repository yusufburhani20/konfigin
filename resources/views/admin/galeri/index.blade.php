@extends('admin.layout')

@section('title', 'Galeri Foto')
@section('page_title', 'Galeri Foto')
@section('page_subtitle', 'Kelola foto-foto kegiatan jurusan')

@section('content')
<div class="card">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <h2 class="card-title">Daftar Foto Galeri</h2>
    <button class="btn btn-primary btn-sm" onclick="openFormModal()">
      <i class="fas fa-plus"></i> Tambah Foto
    </button>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th width="80">Urutan</th>
          <th width="120">Foto</th>
          <th>Judul / Caption</th>
          <th>Link Instagram</th>
          <th width="100">Status</th>
          <th width="150">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data as $row)
        <tr>
          <td style="text-align:center">{{ $row->urutan }}</td>
          <td>
            <img src="{{ asset($row->foto_url) }}" alt="Img" style="width:80px; height:80px; object-fit:cover; border-radius:8px">
          </td>
          <td><strong>{{ $row->judul ?: '(Tidak ada judul)' }}</strong></td>
          <td>
            @if($row->instagram_url && $row->instagram_url !== '#')
            <a href="{{ $row->instagram_url }}" target="_blank" style="color:var(--primary);text-decoration:none"><i class="fab fa-instagram"></i> Lihat Post</a>
            @else
            <span style="color:var(--text-secondary)">-</span>
            @endif
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
              <form method="POST" action="{{ route('admin.galeri.destroy', $row->id) }}" onsubmit="return confirm('Yakin ingin menghapus foto ini? File foto tidak akan terhapus dari server.');" style="margin:0">
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
          <td colspan="6" style="text-align:center; padding:2rem">Belum ada foto galeri.</td>
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
      <h3 class="modal-title" id="modal-title">Tambah / Edit Foto</h3>
      <button type="button" class="modal-close" onclick="closeModal('modal-form')"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <form id="form-data" method="POST" action="" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="POST">
        
        <div class="form-group">
          <label class="form-label" for="foto">Upload Foto <span id="foto-req" style="color:red">*</span></label>
          <input type="file" id="foto" name="foto" class="form-input" accept="image/jpeg,image/png,image/gif,image/webp" required>
          <div class="form-help">Format: JPG, PNG, GIF, WEBP. Maks: 5MB. <br><span id="foto-help" style="display:none;color:var(--accent)">Biarkan kosong jika tidak ingin mengubah foto.</span></div>
        </div>

        <div class="form-group">
          <label class="form-label" for="judul">Judul / Caption (Opsional)</label>
          <input type="text" id="judul" name="judul" class="form-input">
        </div>
        
        <div class="form-group">
          <label class="form-label" for="instagram_url">URL Post Instagram (Opsional)</label>
          <input type="text" id="instagram_url" name="instagram_url" class="form-input" value="#">
          <div class="form-help">Link lengap ke postingan IG-nya.</div>
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
          <button type="submit" class="btn btn-primary">Simpan Foto</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
function openFormModal() {
    document.getElementById('modal-title').innerText = 'Tambah Foto Galeri';
    document.getElementById('form-data').action = '{{ route('admin.galeri.store') }}';
    document.getElementById('form-method').value = 'POST';
    
    document.getElementById('judul').value = '';
    document.getElementById('instagram_url').value = '#';
    document.getElementById('urutan').value = '0';
    document.getElementById('aktif').checked = true;
    
    document.getElementById('foto').required = true;
    document.getElementById('foto-req').style.display = 'inline';
    document.getElementById('foto-help').style.display = 'none';
    
    window.openModal('modal-form');
}

function editData(data) {
    document.getElementById('modal-title').innerText = 'Edit Foto Galeri';
    document.getElementById('form-data').action = '/admin/galeri/' + data.id;
    document.getElementById('form-method').value = 'PUT';
    
    document.getElementById('judul').value = data.judul;
    document.getElementById('instagram_url').value = data.instagram_url;
    document.getElementById('urutan').value = data.urutan;
    document.getElementById('aktif').checked = data.aktif ? true : false;
    
    document.getElementById('foto').required = false;
    document.getElementById('foto-req').style.display = 'none';
    document.getElementById('foto-help').style.display = 'inline';
    
    window.openModal('modal-form');
}
</script>
@endpush
