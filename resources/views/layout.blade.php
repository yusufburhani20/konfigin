<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title') – {{ $site_name ?? 'Konfigin IT Solutions' }}</title>
  <meta name="description" content="Konfigin IT Solutions – Penyedia jasa instalasi jaringan enterprise/sekolah dan pengembangan aplikasi web custom premium berlisensi sekali putus." />
  <meta name="keywords" content="IT Solutions, Jasa Jaringan, Instalasi Jaringan, Custom Web Development, Lisensi Sekali Putus, Konfigin, Software House, Mikrotik" />

  <link rel="canonical" href="{{ url()->current() }}" />

  {{-- OpenGraph --}}
  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:title" content="@yield('title') – {{ $site_name ?? 'TJKT' }}" />
  
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  
  {{-- Dynamic Theme Styling --}}
  <style>
    :root {
      --primary: {{ $site_settings['theme_primary_color'] ?? '#0072ff' }};
      --secondary: {{ $site_settings['theme_secondary_color'] ?? '#00c6ff' }};
      --radius-lg: {{ $site_settings['theme_border_radius'] ?? '20px' }};
      @if(isset($site_settings['theme_primary_color']))
        --hero-gradient: linear-gradient(135deg, #f8fafc 0%, #eff6ff 40%, {{ $site_settings['theme_primary_color'] }}15 70%, {{ $site_settings['theme_secondary_color'] ?? '#00c6ff' }}20 100%);
      @endif
    }
    .btn-primary:hover, .btn-secondary:hover {
        filter: brightness(1.1);
    }
  </style>

  @stack('styles')
</head>
<body>

@if(session('admin_logged_in'))
  <!-- ===== TOP ADMIN BAR ===== -->
  <div class="admin-quick-bar">
    <div class="admin-quick-content">
      <span><i class="fas fa-user-shield" style="color:#38bdf8"></i> Login: <strong>{{ session('admin_nama') }}</strong></span>
      <div class="admin-quick-links">
        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="{{ route('admin.settings.index') }}"><i class="fas fa-cog"></i> Pengaturan</a>
        <a href="{{ route('admin.kurikulum.index') }}"><i class="fas fa-box-open"></i> Tambah Produk</a>
        <a href="{{ route('admin.posts.create') }}"><i class="fas fa-plus-circle"></i> Tulis Blog</a>
        <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0; display: inline;">
          @csrf
          <button type="submit" class="btn-logout-link"><i class="fas fa-sign-out-alt"></i> Keluar</button>
        </form>
      </div>
    </div>
  </div>
  <style>
    .admin-quick-bar {
      background: #0f172a;
      color: #cbd5e1;
      font-size: 0.8rem;
      padding: 8px 2rem;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 99999;
      border-bottom: 1px solid rgba(255,255,255,0.08);
      font-family: 'Inter', sans-serif;
      height: 38px;
    }
    .admin-quick-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
      height: 100%;
    }
    .admin-quick-links {
      display: flex;
      gap: 1.5rem;
      align-items: center;
    }
    .admin-quick-links a, .btn-logout-link {
      color: #94a3b8;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.2s;
      background: none;
      border: none;
      padding: 0;
      cursor: pointer;
      font-size: 0.8rem;
      display: inline-flex;
      align-items: center;
      gap: 0.35rem;
      font-family: 'Inter', sans-serif;
    }
    .admin-quick-links a:hover, .btn-logout-link:hover {
      color: #38bdf8;
    }
    /* Shift body and navbar down if admin bar exists */
    body {
      padding-top: 38px !important;
    }
    .admin-quick-bar + .navbar {
      top: 38px !important;
    }
    @media (max-width: 768px) {
      .admin-quick-bar {
        padding: 8px 1rem;
      }
      .admin-quick-links {
        gap: 0.8rem;
      }
      .admin-quick-content span {
        display: none;
      }
      .admin-quick-content {
        justify-content: center;
      }
    }
  </style>
@endif

<!-- ===== NAVBAR ===== -->
<nav class="navbar" id="navbar" role="navigation" aria-label="Main Navigation">
  <a href="{{ route('home') }}" class="navbar-brand" aria-label="{{ $site_name ?? 'Home' }}">
    <div class="navbar-logo" style="background: transparent; width: auto; height: 48px; padding: 0;">
      <img src="{{ asset('assets/img/konfigin-logo.png') }}" alt="Logo" style="max-height:100%; object-fit:contain;">
    </div>
  </a>
  <ul class="navbar-nav" role="list">
    <li><a href="{{ route('home') }}">Home</a></li>
    @if(request()->routeIs('home'))
        <li><a href="#eservice">Layanan</a></li>
        <li><a href="#kurikulum">Produk</a></li>
        <li><a href="#galeri">Portofolio</a></li>
    @endif
    <li><a href="{{ route('blog.index') }}">Blog</a></li>
    <li><a href="{{ route('home') }}#kontak">Kontak</a></li>
  </ul>
  <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle navigation" aria-expanded="false">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu" role="navigation" aria-label="Mobile Navigation">
  <a href="{{ route('home') }}">Home</a>
  @if(request()->routeIs('home'))
      <a href="#eservice">Layanan</a>
      <a href="#kurikulum">Produk</a>
      <a href="#galeri">Portofolio</a>
  @endif
  <a href="{{ route('blog.index') }}">Blog</a>
  <a href="{{ route('home') }}#kontak">Kontak</a>
</div>

@yield('content')

<!-- ===== FOOTER ===== -->
<footer role="contentinfo">
  <div class="footer-content">
    <div class="footer-brand" style="margin-bottom: 1rem;">
      <img src="{{ asset('assets/img/konfigin-logo.png') }}" alt="Konfigin Logo" style="height: 36px; object-fit: contain;">
    </div>
    <p>© {{ date('Y') }} {{ $site_name ?? 'Konfigin IT Solutions' }}. Jasa Jaringan & Custom Web Development Premium.</p>
    <p style="margin-top:0.5rem">
      <a href="{{ route('admin.login') }}" style="color: var(--text-secondary); font-size:0.8rem; text-decoration:none; opacity:0.6">
        Admin Panel
      </a>
    </p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
@stack('scripts')
</body>
</html>
