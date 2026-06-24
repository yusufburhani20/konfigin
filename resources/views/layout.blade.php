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
  <meta property="og:title" content="@yield('title') – {{ $site_name ?? 'Konfigin IT Solutions' }}" />
  
  <link rel="icon" type="image/x-icon" href="{{ !empty($site_settings['site_favicon']) ? asset($site_settings['site_favicon']) : asset('favicon.ico') }}" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ filemtime(public_path('assets/css/style.css')) }}" />
  
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
      padding: 0 2rem;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 99999;
      border-bottom: 1px solid rgba(255,255,255,0.08);
      font-family: 'Inter', sans-serif;
      height: 40px;
      display: flex;
      align-items: center;
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
      padding-top: 40px !important;
    }
    .admin-quick-bar + .navbar {
      top: 40px !important;
      /* Branded light navbar override when admin bar is present */
      background: rgba(240, 247, 255, 0.95) !important;
      backdrop-filter: blur(24px) !important;
      -webkit-backdrop-filter: blur(24px) !important;
      border-bottom: 1px solid rgba(37, 99, 235, 0.15) !important;
      box-shadow: 0 4px 20px rgba(37, 99, 235, 0.08) !important;
    }
    @media (max-width: 768px) {
      .admin-quick-bar {
        padding: 0 1rem;
        height: 40px;
        overflow-x: auto;
        overflow-y: hidden;
        flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
      }
      .admin-quick-content {
        min-width: max-content;
        padding: 0;
      }
      .admin-quick-links {
        gap: 0.8rem;
        flex-shrink: 0;
      }
      .admin-quick-content span {
        display: none;
      }
    }
  </style>
@endif

<!-- ===== NAVBAR ===== -->
<nav class="navbar {{ request()->routeIs('home') || request()->routeIs('blog.index') || request()->routeIs('blog.show') || request()->routeIs('blog.category') ? 'navbar-home' : 'navbar-page' }}" id="navbar" role="navigation" aria-label="Main Navigation">
  <div class="nav-inner">
    <!-- Logo kustom gaya konfigin -->
    <a href="{{ route('home') }}" class="logo" aria-label="{{ $site_name ?? 'Home' }}">
      <div class="logo-icon">
        <span class="logo-bracket-l">{</span>
        <div class="logo-dot"></div>
        <span class="logo-bracket-r">}</span>
      </div>
      <div class="logo-text">
        <div class="logo-name">konfig<em>in</em></div>
        <div class="logo-sub">IT Solutions</div>
      </div>
    </a>
 
    <div class="nav-links">
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
      <a href="{{ request()->routeIs('home') ? '#eservice' : route('home') . '#eservice' }}">Layanan</a>
      <a href="{{ request()->routeIs('home') ? '#kurikulum' : route('home') . '#kurikulum' }}">Produk</a>
      <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.index') || request()->routeIs('blog.show') || request()->routeIs('blog.category') ? 'active' : '' }}">Blog</a>
      <a href="{{ request()->routeIs('home') ? '#kontak' : route('home') . '#kontak' }}">Kontak</a>
    </div>
 
    <div class="nav-cta">
      <a href="{{ request()->routeIs('home') ? '#galeri' : route('home') . '#galeri' }}" class="btn-nav-ghost">Portofolio</a>
      
      @if(isset($kontak) && $kontak)
        <a href="https://wa.me/{{ str_replace('-', '', filter_var($kontak->whatsapp, FILTER_SANITIZE_NUMBER_INT)) }}?text=Halo%20Konfigin,%20saya%20tertarik%20ingin%20konsultasi%20layanan%20IT%20Solutions" target="_blank" rel="noopener" class="btn-nav-solid">Konsultasi Gratis →</a>
      @else
        <a href="{{ request()->routeIs('home') ? '#kontak' : route('home') . '#kontak' }}" class="btn-nav-solid">Konsultasi Gratis →</a>
      @endif
    </div>

    <!-- Toggle button for mobile -->
    <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle navigation" aria-expanded="false">
      <span></span><span></span><span></span>
    </button>
  </div>
</nav>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu" role="navigation" aria-label="Mobile Navigation">
  <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
  <a href="{{ request()->routeIs('home') ? '#eservice' : route('home') . '#eservice' }}">Layanan</a>
  <a href="{{ request()->routeIs('home') ? '#kurikulum' : route('home') . '#kurikulum' }}">Produk</a>
  <a href="{{ request()->routeIs('home') ? '#galeri' : route('home') . '#galeri' }}">Portofolio</a>
  <a href="{{ route('blog.index') }}" class="{{ request()->routeIs('blog.index') || request()->routeIs('blog.show') || request()->routeIs('blog.category') ? 'active' : '' }}">Blog</a>
  <a href="{{ request()->routeIs('home') ? '#kontak' : route('home') . '#kontak' }}">Kontak</a>
  
  @if(isset($kontak) && $kontak)
    <a href="https://wa.me/{{ str_replace('-', '', filter_var($kontak->whatsapp, FILTER_SANITIZE_NUMBER_INT)) }}?text=Halo%20Konfigin,%20saya%20tertarik%20ingin%20konsultasi%20layanan%20IT%20Solutions" target="_blank" rel="noopener" class="btn-nav-solid" style="margin-top: 10px; text-align: center; display: block;">Konsultasi Gratis →</a>
  @endif
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
      <!--<a href="{{ route('admin.login') }}" style="color: var(--text-secondary); font-size:0.8rem; text-decoration:none; opacity:0.6">
        Admin Panel
      </a> -->
    </p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('assets/js/main.js') }}?v={{ filemtime(public_path('assets/js/main.js')) }}"></script>
@stack('scripts')
</body>
</html>
