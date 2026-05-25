@extends('layout')

@section('title', $site_name)

@section('content')
<!-- ===== HERO SECTION ===== -->
<section id="hero" aria-label="Hero Section">
  <!-- Animated mesh gradient background -->
  <div class="hero-gradient-bg" aria-hidden="true"></div>

  <!-- Subtle clean soft glowing spots (Professional mesh style) -->
  <div class="hero-glow-spots" aria-hidden="true">
    <div class="glow-spot" style="top: 10%; left: 15%; background: rgba(0, 114, 255, 0.15);"></div>
    <div class="glow-spot" style="bottom: 15%; right: 10%; background: rgba(0, 198, 255, 0.15);"></div>
  </div>

  <div class="container hero-container" style="max-width: 1200px; margin: 0 auto; width: 100%;">
    <div class="hero-split-grid">
      <!-- LEFT SIDE: Text and CTA -->
      <div class="hero-content-left animate-on-scroll">
        <div class="hero-badge-modern">
          <span class="badge-dot"></span>
          <span class="badge-text"><i class="fas fa-laptop-code" style="margin-right:6px"></i> Premium IT Solutions &amp; Custom Software</span>
        </div>
        
        <h1 class="hero-title-modern">
          Infrastruktur Jaringan Sekolah, Perkantoran &amp; <span class="gradient-text">Aplikasi Custom</span>
        </h1>
        
        <p class="hero-subtitle-modern">
          Konfigin IT Solutions menghadirkan pengembangan aplikasi kustom premium dan instalasi jaringan handal berlisensi sekali putus—kepemilikan penuh selamanya tanpa biaya langganan bulanan.
        </p>
        
        <div class="hero-actions-modern">
          @if($kontak)
            <a href="https://wa.me/{{ str_replace('-', '', filter_var($kontak->whatsapp, FILTER_SANITIZE_NUMBER_INT)) }}?text=Halo%20Konfigin,%20saya%20tertarik%20ingin%20konsultasi%20layanan%20IT%20Solutions" target="_blank" rel="noopener" class="btn btn-primary" id="btn-hero-wa" style="border-radius:100px; padding:0.8rem 1.8rem; font-weight:700;">
              <i class="fab fa-whatsapp"></i> Konsultasi Jaringan &amp; App
            </a>
          @endif
          <a href="#eservice" class="btn btn-outline" id="btn-hero-layanan" style="border-radius:100px; padding:0.8rem 1.8rem; font-weight:700;">
            <i class="fas fa-cogs"></i> Layanan Utama
          </a>
        </div>
      </div>

      <!-- RIGHT SIDE: Glassmorphic Dashboard & Server Mockup -->
      <div class="hero-visual-right animate-on-scroll">
        <div class="dashboard-mockup">
          <!-- Browser Header Controls -->
          <div class="mockup-header">
            <div class="mockup-dots">
              <span class="dot-red"></span>
              <span class="dot-yellow"></span>
              <span class="dot-green"></span>
            </div>
            <div class="mockup-search-bar"><i class="fas fa-lock"></i> secure.konfigin.com</div>
          </div>
          
          <!-- Mockup Content -->
          <div class="mockup-content">
            <!-- Server Status Bar -->
            <div class="mockup-status-bar">
              <div class="status-indicator">
                <span class="status-pulse-dot"></span>
                <span>SYSTEM STATUS: <strong>ACTIVE / ONLINE</strong></span>
              </div>
              <span class="status-badge-text">v2.4.1</span>
            </div>

            <!-- Mini Dashboard Grid -->
            <div class="mockup-metrics">
              <div class="metric-mini-card">
                <div class="metric-header">
                  <span class="metric-title">NETWORK UPTIME</span>
                  <i class="fas fa-network-wired" style="color:var(--primary)"></i>
                </div>
                <div class="metric-value">99.99%</div>
              </div>
              <div class="metric-mini-card">
                <div class="metric-header">
                  <span class="metric-title">ACTIVE SOCKETS</span>
                  <i class="fas fa-server" style="color:var(--secondary)"></i>
                </div>
                <div class="metric-value">16 / 16 Nodes</div>
              </div>
            </div>

            <!-- Network Connections Graph Visual -->
            <div class="mockup-graph-panel">
              <div class="graph-nodes-container">
                <div class="graph-node-center"><i class="fas fa-shield-alt"></i></div>
                <div class="graph-node satellite-1"><i class="fas fa-database"></i></div>
                <div class="graph-node satellite-2"><i class="fas fa-wifi"></i></div>
                <div class="graph-node satellite-3"><i class="fas fa-laptop-code"></i></div>
                <div class="graph-node satellite-4"><i class="fas fa-terminal"></i></div>
                <!-- Connecting lines via SVG -->
                <svg class="graph-connections" viewBox="0 0 100 100" preserveAspectRatio="none">
                  <line x1="50" y1="50" x2="20" y2="25" stroke="rgba(0,114,255,0.15)" stroke-width="0.8" />
                  <line x1="50" y1="50" x2="80" y2="25" stroke="rgba(0,114,255,0.15)" stroke-width="0.8" />
                  <line x1="50" y1="50" x2="20" y2="75" stroke="rgba(0,114,255,0.15)" stroke-width="0.8" />
                  <line x1="50" y1="50" x2="80" y2="75" stroke="rgba(0,114,255,0.15)" stroke-width="0.8" />
                </svg>
              </div>
            </div>

            <!-- Mini Console Logs -->
            <div class="mockup-console">
              <div class="console-line"><span class="console-tag-ok">[ OK ]</span> Established secure connection to edge router...</div>
              <div class="console-line"><span class="console-tag-info">[INFO]</span> Database backup generated successfully.</div>
              <div class="console-line"><span class="console-tag-sec">[SEC ]</span> Encrypted transmission SSL tunnel active.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Tech Stacks Bar -->
<div class="tech-stacks-bar" aria-label="Technology Stacks">
  <span class="tech-stacks-title">Tech Stack Kami:</span>
  <div class="tech-stacks-list">
    @if(!empty($site_settings['tech_stacks']))
      @foreach(explode(',', $site_settings['tech_stacks']) as $tech)
        @php
          $tech = trim($tech);
          if (empty($tech)) continue;
          if (str_starts_with($tech, 'fa-') || str_contains($tech, ' ')) {
              $iconClass = $tech;
          } else {
              $fabBrands = ['html5', 'css3-alt', 'js', 'php', 'laravel', 'git-alt', 'node-js', 'react', 'vue', 'angular', 'bootstrap', 'sass', 'wordpress'];
              $prefix = in_array($tech, $fabBrands) ? 'fab' : 'fas';
              $iconClass = $prefix . ' fa-' . $tech;
          }
          $title = ucwords(str_replace('-', ' ', $tech));
        @endphp
        <i class="{{ $iconClass }}" title="{{ $title }}"></i>
      @endforeach
    @endif
  </div>
</div>





<!-- ===== E-SERVICE (LAYANAN UTAMA) SECTION ===== -->
<section id="eservice" aria-labelledby="eservice-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <div class="section-label"><i class="fas fa-cogs"></i> Layanan Utama</div>
      <h2 class="section-title" id="eservice-heading">Paket Software untuk Bisnis &amp; Kebutuhan</h2>
      <p class="section-desc">Pilih layanan solusi digital terintegrasi yang dirancang untuk mempercepat pertumbuhan bisnis Anda.</p>
    </div>
    <div class="eservice-grid grid-6">
      @foreach($eservice as $svc)
      <a href="{{ $svc->url }}"
         class="eservice-card premium-card animate-on-scroll"
         target="_blank" rel="noopener"
         id="eservice-{{ $svc->id }}"
         aria-label="{{ $svc->nama }}">
        <div class="eservice-icon" style="background: {{ $svc->warna }}">
          <i class="{{ $svc->icon }}"></i>
        </div>
        <div>
          <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem; font-family: 'Plus Jakarta Sans', sans-serif;">{{ $svc->nama }}</h3>
          <p>{{ $svc->deskripsi }}</p>
        </div>
        <span class="btn btn-ghost btn-sm" style="pointer-events:none; margin-top: auto; border-radius: 100px;">
          <i class="fab fa-whatsapp"></i> Hubungi Kami
        </span>
      </a>
      @endforeach
    </div>
  </div>
</section>

<div class="section-divider"></div>

<!-- ===== KEUNGGULAN (DARK WHY CHOOSE US) SECTION ===== -->
<section id="keunggulan" class="dark-why-us" aria-labelledby="keunggulan-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <div class="section-label"><i class="fas fa-star"></i> Keunggulan</div>
      <h2 class="section-title" id="keunggulan-heading">Kenapa Pilih Konfigin?</h2>
      <p class="section-desc">Komitmen penuh kami dalam memberikan keandalan teknologi terbaik untuk kesuksesan operasional Anda.</p>
    </div>
    <div class="keunggulan-grid grid-8">
      @foreach($keunggulan as $k)
      <div class="keunggulan-card premium-dark-card animate-on-scroll">
        <div class="keunggulan-icon" aria-hidden="true">
          <i class="{{ $k->icon }}"></i>
        </div>
        <h3 style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; color: #ffffff;">{{ $k->judul }}</h3>
        <p style="font-size: 0.85rem; color: #94a3b8; line-height: 1.6;">{{ $k->deskripsi }}</p>
      </div>
      @endforeach
    </div>


  </div>
</section>

<div class="section-divider"></div>

<!-- ===== PRICING (PAKET LISENSI) SECTION ===== -->
<section id="kurikulum" class="pricing-section" aria-labelledby="pricing-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <div class="section-label"><i class="fas fa-tags"></i> Paket Harga</div>
      <h2 class="section-title" id="pricing-heading">Paket Software untuk Semua Skala Bisnis</h2>
      <p class="section-desc">Pilih model lisensi sekali putus yang sesuai dengan kapasitas dan proyeksi bisnis Anda.</p>
    </div>
    
    <div class="pricing-grid-4">
      @foreach($kurikulum as $pkg)
      @php
        $isPopular = !empty($pkg->badge) && strtolower($pkg->badge) === 'populer';
      @endphp
      <div class="pricing-card {{ $isPopular ? 'popular' : '' }} animate-on-scroll">
        @if(!empty($pkg->badge))
          <div class="pricing-badge">{{ $pkg->badge }}</div>
        @endif
        <div class="pricing-name" style="font-family:'Plus Jakarta Sans'; font-weight:800;">{{ $pkg->nama_mapel }}</div>
        <div class="pricing-price">
          <span class="amount">{{ $pkg->harga }}</span>
          <span class="period" style="{{ $isPopular ? 'color:rgba(255,255,255,0.8)' : '' }}">/ Sekali Bayar</span>
        </div>
        <ul class="pricing-features">
          @if(!empty($pkg->fitur))
            @foreach(explode("\n", str_replace("\r", "", $pkg->fitur)) as $feature)
              @php
                $feature = trim($feature);
                if (empty($feature)) continue;
                $isCrossed = str_starts_with($feature, '-');
                $featureText = $isCrossed ? ltrim($feature, '- ') : $feature;
              @endphp
              <li>
                @if($isCrossed)
                  <i class="fas fa-times-circle" style="color:#ef4444; opacity:0.5"></i>
                @else
                  <i class="fas fa-check-circle"></i>
                @endif
                {{ $featureText }}
              </li>
            @endforeach
          @endif
        </ul>
        @php
          $waLink = $pkg->roadmap_url;
          if (empty($waLink) || $waLink === '#') {
              $waLink = $kontak ? 'https://wa.me/' . str_replace('-', '', filter_var($kontak->whatsapp, FILTER_SANITIZE_NUMBER_INT)) . '?text=Halo%20Konfigin,%20saya%20tertarik%20dengan%20' . rawurlencode($pkg->nama_mapel) : '#';
          }
        @endphp
        @if($isPopular)
          <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn" style="width:100%; justify-content:center; background:#ffffff; color:#0072ff; box-shadow:none; border-radius:100px; font-weight:700;">Pilih Paket</a>
        @else
          <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-outline" style="width:100%; justify-content:center; border-radius:100px;">Pilih Paket</a>
        @endif
      </div>
      @endforeach
    </div>
  </div>
</section>



<!-- ===== PORTFOLIO (HASIL KARYA KAMI) SECTION ===== 
<section id="galeri" aria-labelledby="galeri-heading" style="background:#f8fafc;">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <div class="section-label"><i class="fas fa-laptop-code"></i> Portofolio</div>
      <p class="section-desc">Lihat portofolio pengerjaan instalasi jaringan dan sistem aplikasi kustom yang telah sukses kami deplosikan.</p>
    </div>

    <div class="eservice-grid">
      @foreach($galeri as $g)
      <div class="portfolio-card-premium animate-on-scroll">
        <div class="portfolio-thumbnail-wrap">
          <img src="{{ asset($g->foto_url) }}" alt="{{ $g->judul }}">
          <div class="portfolio-hover-overlay">
            <span class="btn-view-project"><i class="fas fa-search-plus"></i> Lihat Detail</span>
          </div>
        </div>
        <div class="portfolio-details">
          <div class="portfolio-category">{{ $g->instagram_url ?? 'IT Solution Project' }}</div>
          <h3>{{ $g->judul }}</h3>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>-->

<!-- ===== DUAL CTA SECTION ===== -->
<section id="kontak" class="dual-cta-section" aria-labelledby="kontak-heading">
  <div class="container">
    <div class="section-header animate-on-scroll">
      <div class="section-label"><i class="fas fa-phone-alt"></i> Kontak Kami</div>
      <h2 class="section-title" id="kontak-heading">Siap Punya Software Profesional?</h2>
      <p class="section-desc">Konsultasikan kebutuhan IT Solutions atau instalasi jaringan Anda secara gratis bersama tim ahli kami.</p>
    </div>
    
    <div class="dual-cta-grid">
      <!-- WHATSAPP CTA -->
      <div class="cta-card whatsapp animate-on-scroll">
        <div class="cta-card-icon"><i class="fab fa-whatsapp"></i></div>
        <h3>Konsultasi Kilat via WhatsApp</h3>
        <p>Hubungi tim technical consultant kami secara langsung untuk respon cepat seputar harga, fitur, dan survei lokasi instalasi jaringan.</p>
        @if($kontak)
        <a href="https://wa.me/{{ $kontak->whatsapp_formatted }}?text=Halo%20Konfigin,%20saya%20tertarik%20ingin%20konsultasi%20layanan%20IT%20Solutions" target="_blank" rel="noopener" class="btn" style="background:#ffffff; color:#059669; border-radius:100px; margin-top:1.5rem; font-weight:700;">Hubungi WhatsApp</a>
        @endif
      </div>

      <!-- EMAIL CTA -->
      <div class="cta-card email animate-on-scroll">
        <div class="cta-card-icon"><i class="fas fa-envelope"></i></div>
        <h3>Kirim Penawaran via Email</h3>
        <p>Ajukan dokumen Kerangka Acuan Kerja (KAK), spesifikasi teknis, atau permintaan penawaran harga resmi (RFP) langsung ke email kami.</p>
        @if($kontak)
        <a href="mailto:{{ $kontak->email }}" class="btn" style="background:#ffffff; color:#0072ff; border-radius:100px; margin-top:1.5rem; font-weight:700;">Kirim Email Resmi</a>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
