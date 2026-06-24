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
  <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}" />
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

<script src="{{ asset('assets/js/admin.js') }}"></script>
@stack('scripts')
</body>
</html>
