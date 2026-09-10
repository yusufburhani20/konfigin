<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Dashboard') – Admin Konfigin IT Solutions</title>
  <meta name="robots" content="noindex, nofollow" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="icon" type="image/x-icon" href="{{ !empty($site_settings['site_favicon']) ? asset($site_settings['site_favicon']) : asset('favicon.ico') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}?v={{ filemtime(public_path('assets/css/admin.css')) }}" />
  @stack('styles')
</head>
<body>
<div class="admin-layout">

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar" role="navigation" aria-label="Sidebar Navigation">
    <div class="sidebar-header">
      <div class="sidebar-logo">
        @php $siteLogo = \App\Models\Setting::get('site_logo'); @endphp
        @if($siteLogo)
          <img src="{{ asset($siteLogo) }}" alt="Logo" style="max-width:100%; max-height:100%; object-fit:contain;">
        @else
          TJ
        @endif
      </div>
      <div class="sidebar-brand">
        <h1>Konfigin IT</h1>
        <span>Admin Panel</span>
      </div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-section-title">Utama</div>
      <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" id="nav-dashboard">
        <i class="fas fa-tachometer-alt"></i> Dashboard
      </a>

      <div class="nav-section-title">Manajemen Konten</div>
      <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" id="nav-settings">
        <i class="fas fa-cog"></i> Pengaturan Umum
      </a>
      <a href="{{ route('admin.kurikulum.index') }}" class="sidebar-link {{ request()->routeIs('admin.kurikulum.*') ? 'active' : '' }}" id="nav-kurikulum">
        <i class="fas fa-box-open"></i> Produk Aplikasi
      </a>
      <a href="{{ route('admin.galeri.index') }}" class="sidebar-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}" id="nav-galeri">
        <i class="fas fa-images"></i> Galeri &amp; Portofolio
      </a>
      <a href="{{ route('admin.eservice.index') }}" class="sidebar-link {{ request()->routeIs('admin.eservice.*') ? 'active' : '' }}" id="nav-eservice">
        <i class="fas fa-cogs"></i> Layanan IT
      </a>
      <a href="{{ route('admin.keunggulan.index') }}" class="sidebar-link {{ request()->routeIs('admin.keunggulan.*') ? 'active' : '' }}" id="nav-keunggulan">
        <i class="fas fa-star"></i> Keunggulan
      </a>
      <a href="{{ route('admin.kontak.edit') }}" class="sidebar-link {{ request()->routeIs('admin.kontak.*') ? 'active' : '' }}" id="nav-kontak">
        <i class="fas fa-phone-alt"></i> Kontak
      </a>

      <div class="nav-section-title">Akun & Sistem</div>
      <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" id="nav-users">
        <i class="fas fa-users"></i> Pengguna (Level)
      </a>

      <div class="nav-section-title">Konten Blog</div>
      <a href="{{ route('admin.posts.index') }}" class="sidebar-link {{ request()->routeIs('admin.posts.index') ? 'active' : '' }}" id="nav-posts">
        <i class="fas fa-newspaper"></i> Daftar Postingan
      </a>
      <a href="{{ route('admin.posts.create') }}" class="sidebar-link {{ request()->routeIs('admin.posts.create') ? 'active' : '' }}" id="nav-posts-create">
        <i class="fas fa-plus-circle"></i> Tulis Post Baru
      </a>
      <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" id="nav-categories">
        <i class="fas fa-tags"></i> Kategori Post
      </a>
      <a href="{{ route('admin.pages.index') }}" class="sidebar-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" id="nav-pages">
        <i class="fas fa-file-alt"></i> Halaman (Pages)
      </a>
      <a href="{{ route('home') }}" class="sidebar-link" id="nav-view-site" target="_blank">
        <i class="fas fa-external-link-alt"></i> Lihat Website
      </a>
      <form method="POST" action="{{ route('admin.logout') }}" style="margin:0">
        @csrf
        <button type="submit" class="sidebar-link danger" id="nav-logout" style="width:100%;text-align:left;background:none;border:none;cursor:pointer;padding:0.75rem 1.25rem;display:flex;align-items:center;gap:0.75rem;color:inherit;font-size:inherit;">
          <i class="fas fa-sign-out-alt"></i> Keluar
        </button>
      </form>
    </nav>

    <div class="sidebar-footer">
      <div class="admin-profile">
        <div class="admin-avatar"><i class="fas fa-user"></i></div>
        <div class="admin-info">
          <div class="admin-name">{{ session('admin_nama', 'Admin') }}</div>
          <div class="admin-role">Administrator</div>
        </div>
      </div>
    </div>
  </aside>

  <!-- MAIN -->
  <main class="admin-main">
    <header class="admin-header">
      <div>
        <div class="header-title">@yield('page_title', 'Dashboard')</div>
        <div class="header-subtitle">@yield('page_subtitle', 'Konfigin IT Solutions – Panel Admin')</div>
      </div>
      <div class="header-actions">
        <button type="button" class="btn btn-danger btn-sm" id="btn-deploy-server" style="background: var(--danger);">
          <i class="fas fa-rocket"></i> Deploy
        </button>
        <a href="{{ route('home') }}" class="btn btn-secondary btn-sm" target="_blank" id="btn-view-site">
          <i class="fas fa-eye"></i> Lihat Website
        </a>
        <form method="POST" action="{{ route('admin.logout') }}" style="display:inline">
          @csrf
          <button type="submit" class="btn btn-danger btn-sm" id="btn-logout-header">
            <i class="fas fa-sign-out-alt"></i> Keluar
          </button>
        </form>
      </div>
    </header>

    <div class="admin-content">

      {{-- Flash Messages --}}
      @if(session('success'))
      <div class="alert alert-success" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
      </div>
      @endif
      @if(session('error'))
      <div class="alert alert-error" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
      </div>
      @endif
      @if($errors->any())
      <div class="alert alert-error" role="alert">
        <i class="fas fa-exclamation-circle"></i>
        <ul style="margin:0.5rem 0 0 1rem">
          @foreach($errors->all() as $e)
          <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      @yield('content')
    </div>
  </main>
</div>

<!-- Deploy Modal -->
<div class="modal-overlay" id="deploy-modal">
  <div class="modal" style="max-width: 800px;">
    <div class="modal-header">
      <h3><i class="fas fa-rocket" style="color: var(--danger);"></i> Deployment Server</h3>
      <button class="modal-close" id="close-deploy-modal"><i class="fas fa-times"></i></button>
    </div>
    <div class="modal-body">
      <p id="deploy-status" style="margin-bottom: 15px; font-weight: 600;">Menunggu perintah deploy...</p>
      <pre id="deploy-log" style="background: #0f172a; color: #10b981; padding: 15px; border-radius: 8px; min-height: 200px; max-height: 400px; overflow-y: auto; font-family: monospace; font-size: 0.85rem; border: 1px solid var(--border); white-space: pre-wrap;"></pre>
    </div>
    <div class="modal-footer">
      <form action="{{ route('admin.deploy') }}" method="POST" id="deploy-form">
        @csrf
        <button type="button" class="btn btn-secondary" id="btn-cancel-deploy">Batal</button>
        <button type="submit" class="btn btn-danger" id="btn-confirm-deploy" style="background: var(--danger);"><i class="fas fa-play"></i> Mulai Deploy</button>
      </form>
    </div>
  </div>
</div>

<script src="{{ asset('assets/js/admin.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const btnDeployServer = document.getElementById('btn-deploy-server');
  const deployModal = document.getElementById('deploy-modal');
  const closeDeployModal = document.getElementById('close-deploy-modal');
  const btnCancelDeploy = document.getElementById('btn-cancel-deploy');
  const deployForm = document.getElementById('deploy-form');
  const deployStatus = document.getElementById('deploy-status');
  const deployLog = document.getElementById('deploy-log');
  const btnConfirmDeploy = document.getElementById('btn-confirm-deploy');

  if(btnDeployServer && deployModal) {
    btnDeployServer.addEventListener('click', function() {
      deployModal.classList.add('open');
      deployStatus.innerHTML = 'Siap melakukan deployment (tarik kode terbaru dari GitHub & build). Klik "Mulai Deploy" untuk melanjutkan.';
      deployStatus.style.color = 'var(--text-primary)';
      deployLog.innerHTML = '> _\n';
      btnConfirmDeploy.disabled = false;
      btnConfirmDeploy.innerHTML = '<i class="fas fa-play"></i> Mulai Deploy';
    });
  }

  if(closeDeployModal) closeDeployModal.addEventListener('click', () => deployModal.classList.remove('open'));
  if(btnCancelDeploy) btnCancelDeploy.addEventListener('click', () => deployModal.classList.remove('open'));

  if(deployForm) {
    deployForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      if(!confirm('Apakah Anda yakin ingin memulai proses deployment sekarang? Web mungkin tidak dapat diakses selama beberapa detik.')) {
        return;
      }

      btnConfirmDeploy.disabled = true;
      btnConfirmDeploy.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Proses...';
      deployStatus.innerHTML = 'Sedang menjalankan proses deployment, harap tunggu...';
      deployStatus.style.color = 'var(--accent)';
      deployLog.innerHTML = '> Menjalankan script deploy.sh...\n';

      const formData = new FormData(deployForm);

      fetch(deployForm.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        deployLog.innerHTML += data.log + '\n';
        if(data.success) {
          let seconds = 3;
          deployStatus.style.color = 'var(--success)';
          
          const countdown = setInterval(() => {
            deployStatus.innerHTML = `Deployment berhasil! Merefresh halaman dalam ${seconds} detik...`;
            if(seconds === 0) {
              clearInterval(countdown);
              window.location.reload(true);
            }
            seconds--;
          }, 1000);
        } else {
          deployStatus.innerHTML = 'Deployment gagal!';
          deployStatus.style.color = 'var(--danger)';
          btnConfirmDeploy.disabled = false;
          btnConfirmDeploy.innerHTML = '<i class="fas fa-redo"></i> Coba Lagi';
        }
      })
      .catch(error => {
        deployLog.innerHTML += '\nError koneksi atau server: ' + error.message;
        deployStatus.innerHTML = 'Terjadi kesalahan sistem saat komunikasi dengan server.';
        deployStatus.style.color = 'var(--danger)';
        btnConfirmDeploy.disabled = false;
        btnConfirmDeploy.innerHTML = '<i class="fas fa-redo"></i> Coba Lagi';
      });
    });
  }
});
</script>
@stack('scripts')
</body>
</html>
