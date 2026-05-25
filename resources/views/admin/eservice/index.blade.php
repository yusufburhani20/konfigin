@extends('admin.layout')

@section('title', 'Layanan E-Service')
@section('page_title', 'Layanan E-Service')
@section('page_subtitle', 'Kelola daftar layanan digital sekolah')

@section('content')
<div class="card">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <h2 class="card-title">Daftar E-Service</h2>
    <button class="btn btn-primary btn-sm" onclick="openFormModal()">
      <i class="fas fa-plus"></i> Tambah Layanan
    </button>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th width="80">Urutan</th>
          <th width="80">Icon</th>
          <th>Nama Layanan & Deskripsi</th>
          <th>URL Layanan</th>
          <th width="100">Status</th>
          <th width="150">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data as $row)
        <tr>
          <td style="text-align:center">{{ $row->urutan }}</td>
          <td style="text-align:center">
            <div style="width:40px; height:40px; border-radius:8px; display:inline-flex; align-items:center; justify-content:center; color:white; background: {{ $row->warna }}">
              <i class="{{ $row->icon }}"></i>
            </div>
          </td>
          <td>
            <strong>{{ $row->nama }}</strong>
            <div style="font-size:0.85rem; color:var(--text-secondary); margin-top:4px">{{ $row->deskripsi }}</div>
          </td>
          <td>
            <a href="{{ $row->url }}" target="_blank" style="color:var(--primary);text-decoration:none">
              {{ $row->url }} <i class="fas fa-external-link-alt" style="font-size:0.8rem"></i>
            </a>
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
              <form method="POST" action="{{ route('admin.eservice.destroy', $row->id) }}" onsubmit="return confirm('Yakin ingin menghapus layanan ini?');" style="margin:0">
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
          <td colspan="6" style="text-align:center; padding:2rem">Belum ada data e-service.</td>
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
      <h3 class="modal-title" id="modal-title">Tambah / Edit Layanan</h3>
      <button type="button" class="modal-close" onclick="closeModal('modal-form')"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <form id="form-data" method="POST" action="">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="POST">
        
        <div class="form-group">
          <label class="form-label" for="nama">Nama Layanan</label>
          <input type="text" id="nama" name="nama" class="form-input" required>
        </div>

        <div class="form-group">
          <label class="form-label" for="deskripsi">Deskripsi Singkat</label>
          <textarea id="deskripsi" name="deskripsi" class="form-input" rows="3"></textarea>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="url">URL Tujuan</label>
          <input type="text" id="url" name="url" class="form-input" placeholder="https://" required>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem">
          <div class="form-group">
            <label class="form-label" for="icon">Icon Class (FontAwesome)</label>
            <input type="text" id="icon" name="icon" class="form-input" value="fas fa-globe">
            <div class="form-help">Contoh: fas fa-globe</div>
          </div>
          <div class="form-group">
            <label class="form-label" for="warna">Warna Background (Hex)</label>
            <input type="color" id="warna" name="warna" class="form-input" style="height:42px; padding:4px" value="#0d6efd">
          </div>
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
    document.getElementById('modal-title').innerText = 'Tambah Layanan E-Service';
    document.getElementById('form-data').action = '{{ route('admin.eservice.store') }}';
    document.getElementById('form-method').value = 'POST';
    
    document.getElementById('nama').value = '';
    document.getElementById('deskripsi').value = '';
    document.getElementById('url').value = '';
    document.getElementById('icon').value = 'fas fa-globe';
    document.getElementById('warna').value = '#0d6efd';
    document.getElementById('urutan').value = '0';
    document.getElementById('aktif').checked = true;
    
    window.openModal('modal-form');
}

function editData(data) {
    document.getElementById('modal-title').innerText = 'Edit Layanan E-Service';
    document.getElementById('form-data').action = '/admin/eservice/' + data.id;
    document.getElementById('form-method').value = 'PUT';
    
    document.getElementById('nama').value = data.nama;
    document.getElementById('deskripsi').value = data.deskripsi;
    document.getElementById('url').value = data.url;
    document.getElementById('icon').value = data.icon;
    document.getElementById('warna').value = data.warna;
    document.getElementById('urutan').value = data.urutan;
    document.getElementById('aktif').checked = data.aktif ? true : false;
    
    window.openModal('modal-form');
}
</script>
@endpush
