@extends('admin.layout')

@section('title', 'Manajemen Produk Aplikasi')
@section('page_title', 'Manajemen Produk Aplikasi')
@section('page_subtitle', 'Kelola data produk aplikasi web berlisensi sekali putus')

@section('content')
<div class="card">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <h2 class="card-title">Daftar Produk Aplikasi</h2>
    <button class="btn btn-primary btn-sm" onclick="openFormModal()">
      <i class="fas fa-plus"></i> Tambah Data
    </button>
  </div>
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th width="80">Urutan</th>
          <th>Nama Aplikasi</th>
          <th>Harga</th>
          <th>Badge</th>
          <th>Demo / Pembelian</th>
          <th width="100">Status</th>
          <th width="150">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($data as $row)
        <tr>
          <td style="text-align:center">{{ $row->urutan }}</td>
          <td><strong>{{ $row->nama_mapel }}</strong></td>
          <td><span style="font-weight:700; color:var(--primary)">{{ $row->harga }}</span></td>
          <td>
            @if($row->badge)
              <span class="badge badge-info">{{ $row->badge }}</span>
            @else
              <span style="color:var(--text-muted); font-size:0.85rem">-</span>
            @endif
          </td>
          <td>
            <div style="font-size:0.8rem">
              <div><i class="fas fa-link"></i> <a href="{{ $row->modul_url }}" target="_blank" title="{{ $row->modul_url }}" style="color:var(--primary);text-decoration:none">Live Demo</a></div>
              <div><i class="fas fa-shopping-cart"></i> <a href="{{ $row->roadmap_url }}" target="_blank" title="{{ $row->roadmap_url }}" style="color:var(--primary);text-decoration:none">WhatsApp Order</a></div>
            </div>
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
              <button class="btn btn-secondary btn-sm" onclick="editData({{ json_encode($row) }})" title="Edit">
                <i class="fas fa-edit"></i>
              </button>
              <form method="POST" action="{{ route('admin.kurikulum.destroy', $row->id) }}" onsubmit="return confirm('Yakin ingin menghapus data ini?');" style="margin:0">
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
          <td colspan="5" style="text-align:center; padding:2rem">Belum ada data produk aplikasi.</td>
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
      <h3 class="modal-title" id="modal-title">Tambah / Edit Data</h3>
      <button type="button" class="modal-close" onclick="closeModal('modal-form')"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <form id="form-data" method="POST" action="">
        @csrf
        <input type="hidden" name="_method" id="form-method" value="POST">
        
        <div class="form-group">
          <label class="form-label" for="nama_mapel">Nama Aplikasi</label>
          <input type="text" id="nama_mapel" name="nama_mapel" class="form-input" required>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="modul_url">URL Live Demo</label>
          <input type="text" id="modul_url" name="modul_url" class="form-input" value="#">
          <div class="form-help">Mulai dengan http:// atau https://</div>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="roadmap_url">URL Info Pembelian (WhatsApp Link)</label>
          <input type="text" id="roadmap_url" name="roadmap_url" class="form-input" value="#">
          <div class="form-help">Mulai dengan http:// atau https://</div>
        </div>
        
        <div class="form-group">
          <label class="form-label" for="urutan">Urutan Tampil</label>
          <input type="number" id="urutan" name="urutan" class="form-input" value="0" required>
          <div class="form-help">Angka kecil tampil lebih dulu</div>
        </div>

        <div class="form-group">
          <label class="form-label" for="harga">Harga Lisensi</label>
          <input type="text" id="harga" name="harga" class="form-input" placeholder="Contoh: Rp 5Jt atau Custom">
          <div class="form-help">Harga yang ditampilkan di kartu paket.</div>
        </div>

        <div class="form-group">
          <label class="form-label" for="badge">Badge Paket (Opsional)</label>
          <input type="text" id="badge" name="badge" class="form-input" placeholder="Contoh: Populer">
          <div class="form-help">Biarkan kosong jika tidak ingin menampilkan lencana di atas kartu.</div>
        </div>

        <div class="form-group">
          <label class="form-label" for="fitur">Fitur Lisensi (Satu baris per fitur)</label>
          <textarea id="fitur" name="fitur" class="form-input" rows="5" placeholder="Contoh:&#10;Unlimited Users&#10;Fitur POS Kasir Lengkap&#10;- Integrasi Printer Thermal"></textarea>
          <div class="form-help">Tulis fitur per-baris. Baris yang diawali dengan tanda minus <code>-</code> akan ditampilkan sebagai silang merah (tidak didukung).</div>
        </div>
        
        <div class="form-group">
          <label class="form-label">
            <input type="checkbox" id="aktif" name="aktif" value="1" checked> Aktif (Tampilkan di halaman)
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
    document.getElementById('modal-title').innerText = 'Tambah Produk Aplikasi';
    document.getElementById('form-data').action = '{{ route('admin.kurikulum.store') }}';
    document.getElementById('form-method').value = 'POST';
    
    document.getElementById('nama_mapel').value = '';
    document.getElementById('modul_url').value = '#';
    document.getElementById('roadmap_url').value = '#';
    document.getElementById('urutan').value = '0';
    document.getElementById('aktif').checked = true;
    document.getElementById('harga').value = '';
    document.getElementById('badge').value = '';
    document.getElementById('fitur').value = '';
    
    window.openModal('modal-form');
}

function editData(data) {
    document.getElementById('modal-title').innerText = 'Edit Produk Aplikasi';
    document.getElementById('form-data').action = '/admin/kurikulum/' + data.id;
    document.getElementById('form-method').value = 'PUT';
    
    document.getElementById('nama_mapel').value = data.nama_mapel;
    document.getElementById('modul_url').value = data.modul_url;
    document.getElementById('roadmap_url').value = data.roadmap_url;
    document.getElementById('urutan').value = data.urutan;
    document.getElementById('aktif').checked = data.aktif ? true : false;
    document.getElementById('harga').value = data.harga || '';
    document.getElementById('badge').value = data.badge || '';
    document.getElementById('fitur').value = data.fitur || '';
    
    window.openModal('modal-form');
}
</script>
@endpush
