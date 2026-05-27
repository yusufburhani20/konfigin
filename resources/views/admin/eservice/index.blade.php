@extends('admin.layout')

@section('title', 'Layanan E-Service')
@section('page_title', 'Layanan E-Service')
@section('page_subtitle', 'Kelola daftar layanan IT Solutions - tambahkan link Halaman untuk penjelasan lebih lanjut')

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
          <td style="max-width: 220px; word-break: break-all;">
            <div style="display:flex; align-items:center; gap:0.5rem">
              <a href="{{ $row->url }}" target="_blank" style="color:var(--primary);text-decoration:none">
                {{ Str::limit($row->url, 35) }} <i class="fas fa-external-link-alt" style="font-size:0.8rem"></i>
              </a>
              <button class="btn btn-secondary btn-sm" onclick="copyToClipboard('{{ $row->url }}', this)" title="Salin URL" style="padding: 2px 6px; font-size: 0.75rem; background: var(--glass); border: 1px solid var(--border);">
                <i class="far fa-copy"></i>
              </button>
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
            <div style="display:flex; gap:0.35rem">
              <button class="btn btn-secondary btn-sm" onclick="editData({{ json_encode($row) }})" title="Edit">
                <i class="fas fa-edit"></i>
              </button>
              <button class="btn btn-secondary btn-sm" onclick="duplicateData({{ json_encode($row) }})" title="Duplikat Layanan">
                <i class="fas fa-copy" style="color:var(--accent)"></i>
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
          <label class="form-label" for="url">URL Tujuan (WA / Eksternal)</label>
          <input type="text" id="url" name="url" class="form-input" placeholder="https://" required>
          <div class="form-help">URL saat tombol "Hubungi Kami" diklik.</div>
        </div>

        <div class="form-group">
          <label class="form-label" for="blog_slug">Slug Halaman (Opsional – untuk tombol "Selengkapnya")</label>
          <input type="text" id="blog_slug" name="blog_slug" class="form-input" placeholder="nama-slug-halaman">
          <div class="form-help">Masukkan slug halaman (pages) yang menjelaskan layanan ini. Kosongkan jika tidak ada.</div>
        </div>

        <div class="form-group">
          <label class="form-label" for="demo_url">URL Demo (Opsional – untuk tombol "Demo")</label>
          <input type="text" id="demo_url" name="demo_url" class="form-input" placeholder="https://demo.konfigin.com/...">
          <div class="form-help">Link halaman demo atau try-out aplikasi. Kosongkan jika tidak tersedia.</div>
        </div>

        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem">
          <div class="form-group">
            <label class="form-label" for="icon">Icon Class (FontAwesome)</label>
            <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
              <div id="icon-preview-box" style="width: 42px; height: 42px; border-radius: 8px; border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; background: #0d6efd; font-size: 1.2rem; flex-shrink: 0; color: white; transition: var(--transition);">
                <i id="icon-preview-icon" class="fas fa-globe"></i>
              </div>
              <input type="text" id="icon" name="icon" class="form-input" value="fas fa-globe" oninput="updateIconPreview(this.value)" style="flex: 1;" required>
            </div>
            <div class="form-help">Pilih icon cepat di bawah ini:</div>
          </div>
          <div class="form-group">
            <label class="form-label" for="warna">Warna Background (Hex)</label>
            <input type="color" id="warna" name="warna" class="form-input" style="height:42px; padding:4px; cursor: pointer;" value="#0d6efd" onchange="updateIconBgPreview(this.value)">
          </div>
        </div>

        <style>
          .icon-picker-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.03);
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid var(--border);
            margin-bottom: 1.5rem;
          }
          .icon-picker-item {
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            border: 1px solid transparent;
            text-align: center;
            font-size: 1.25rem;
            color: var(--text-secondary);
            transition: all 0.2s ease;
          }
          .icon-picker-item:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: scale(1.1);
          }
          .icon-picker-item.active {
            background: var(--primary) !important;
            color: white !important;
            border-color: var(--primary) !important;
            box-shadow: 0 0 10px rgba(14, 165, 233, 0.5);
          }
        </style>

        <div class="icon-picker-grid">
          <div class="icon-picker-item" onclick="selectIcon('fas fa-globe')" data-icon="fas fa-globe" title="Globe"><i class="fas fa-globe"></i></div>
          <div class="icon-picker-item" onclick="selectIcon('fas fa-code')" data-icon="fas fa-code" title="Code"><i class="fas fa-code"></i></div>
          <div class="icon-picker-item" onclick="selectIcon('fas fa-server')" data-icon="fas fa-server" title="Server/Hosting"><i class="fas fa-server"></i></div>
          <div class="icon-picker-item" onclick="selectIcon('fas fa-shield-alt')" data-icon="fas fa-shield-alt" title="Keamanan"><i class="fas fa-shield-alt"></i></div>
          <div class="icon-picker-item" onclick="selectIcon('fas fa-credit-card')" data-icon="fas fa-credit-card" title="Pembayaran"><i class="fas fa-credit-card"></i></div>
          <div class="icon-picker-item" onclick="selectIcon('fas fa-key')" data-icon="fas fa-key" title="Lisensi/Key"><i class="fas fa-key"></i></div>
          <div class="icon-picker-item" onclick="selectIcon('fas fa-network-wired')" data-icon="fas fa-network-wired" title="Jaringan"><i class="fas fa-network-wired"></i></div>
          <div class="icon-picker-item" onclick="selectIcon('fas fa-database')" data-icon="fas fa-database" title="Database"><i class="fas fa-database"></i></div>
          <div class="icon-picker-item" onclick="selectIcon('fas fa-laptop-code')" data-icon="fas fa-laptop-code" title="Aplikasi Web"><i class="fas fa-laptop-code"></i></div>
          <div class="icon-picker-item" onclick="selectIcon('fas fa-mobile-alt')" data-icon="fas fa-mobile-alt" title="Mobile App"><i class="fas fa-mobile-alt"></i></div>
          <div class="icon-picker-item" onclick="selectIcon('fas fa-cloud')" data-icon="fas fa-cloud" title="Cloud System"><i class="fas fa-cloud"></i></div>
          <div class="icon-picker-item" onclick="selectIcon('fas fa-chart-line')" data-icon="fas fa-chart-line" title="SaaS/Analitik"><i class="fas fa-chart-line"></i></div>
          <div class="icon-picker-item" onclick="selectIcon('fas fa-headset')" data-icon="fas fa-headset" title="Dukungan Teknis"><i class="fas fa-headset"></i></div>
          <div class="icon-picker-item" onclick="selectIcon('fas fa-wifi')" data-icon="fas fa-wifi" title="WiFi/Internet"><i class="fas fa-wifi"></i></div>
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
    document.getElementById('blog_slug').value = '';
    document.getElementById('demo_url').value = '';
    
    const defaultIcon = 'fas fa-globe';
    const defaultWarna = '#0d6efd';
    document.getElementById('icon').value = defaultIcon;
    document.getElementById('warna').value = defaultWarna;
    updateIconPreview(defaultIcon);
    updateIconBgPreview(defaultWarna);
    highlightActiveIcon(defaultIcon);
    
    document.getElementById('urutan').value = '0';
    document.getElementById('aktif').checked = true;
    
    window.openModal('modal-form');
}

function editData(data) {
    document.getElementById('modal-title').innerText = 'Edit Layanan E-Service';
    document.getElementById('form-data').action = '/admin/eservice/' + data.id;
    document.getElementById('form-method').value = 'PUT';
    
    document.getElementById('nama').value = data.nama;
    document.getElementById('deskripsi').value = data.deskripsi || '';
    document.getElementById('url').value = data.url || '';
    document.getElementById('blog_slug').value = data.blog_slug || '';
    document.getElementById('demo_url').value = data.demo_url || '';
    
    document.getElementById('icon').value = data.icon || 'fas fa-globe';
    document.getElementById('warna').value = data.warna || '#0d6efd';
    updateIconPreview(data.icon || 'fas fa-globe');
    updateIconBgPreview(data.warna || '#0d6efd');
    highlightActiveIcon(data.icon || 'fas fa-globe');
    
    document.getElementById('urutan').value = data.urutan;
    document.getElementById('aktif').checked = data.aktif ? true : false;
    
    window.openModal('modal-form');
}

function duplicateData(data) {
    document.getElementById('modal-title').innerText = 'Duplikat Layanan E-Service';
    document.getElementById('form-data').action = '{{ route('admin.eservice.store') }}';
    document.getElementById('form-method').value = 'POST';
    
    document.getElementById('nama').value = data.nama + ' (Copy)';
    document.getElementById('deskripsi').value = data.deskripsi || '';
    document.getElementById('url').value = data.url || '';
    document.getElementById('blog_slug').value = data.blog_slug || '';
    document.getElementById('demo_url').value = data.demo_url || '';
    
    document.getElementById('icon').value = data.icon || 'fas fa-globe';
    document.getElementById('warna').value = data.warna || '#0d6efd';
    updateIconPreview(data.icon || 'fas fa-globe');
    updateIconBgPreview(data.warna || '#0d6efd');
    highlightActiveIcon(data.icon || 'fas fa-globe');
    
    document.getElementById('urutan').value = parseInt(data.urutan) + 1;
    document.getElementById('aktif').checked = data.aktif ? true : false;
    
    window.openModal('modal-form');
}

function selectIcon(iconClass) {
    document.getElementById('icon').value = iconClass;
    updateIconPreview(iconClass);
    highlightActiveIcon(iconClass);
}

function updateIconPreview(iconClass) {
    const previewIcon = document.getElementById('icon-preview-icon');
    previewIcon.className = iconClass || 'fas fa-globe';
}

function updateIconBgPreview(color) {
    const previewBox = document.getElementById('icon-preview-box');
    if (previewBox) {
        previewBox.style.backgroundColor = color || '#0d6efd';
    }
}

function highlightActiveIcon(iconClass) {
    document.querySelectorAll('.icon-picker-item').forEach(el => {
        el.classList.remove('active');
    });
    const activeItem = document.querySelector(`.icon-picker-item[data-icon="${iconClass}"]`);
    if (activeItem) {
        activeItem.classList.add('active');
    }
}

function copyToClipboard(text, btn) {
    navigator.clipboard.writeText(text).then(function() {
        const icon = btn.querySelector('i');
        const oldClass = icon.className;
        icon.className = 'fas fa-check';
        icon.style.color = '#10b981';
        btn.title = 'Berhasil disalin!';
        
        setTimeout(function() {
            icon.className = oldClass;
            icon.style.color = '';
            btn.title = 'Salin URL';
        }, 1500);
    }).catch(function(err) {
        console.error('Gagal menyalin link: ', err);
        alert('Gagal menyalin link ke clipboard.');
    });
}
</script>
@endpush
