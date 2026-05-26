@extends('layout')

@section('title', $site_name)

@if(session('admin_logged_in'))
@push('styles')
<style>
  /* Admin quick bar (40px) + navbar (72px) + extra space = 150px total top padding on hero */
  #hero { padding-top: 150px !important; }
</style>
@endpush
@endif

@section('content')
<!-- ===== HERO SECTION ===== -->
<section id="hero" aria-label="Hero Section">
  <!-- Video Background -->
  <video class="hero-video-bg" autoplay loop muted playsinline aria-hidden="true">
    <source src="{{ asset('assets/img/global_network_background_animation.mp4') }}" type="video/mp4">
  </video>

  <div class="orb orb-1" aria-hidden="true"></div>
  <div class="orb orb-2" aria-hidden="true"></div>
  <div class="orb orb-3" aria-hidden="true"></div>

  <div class="hero-bg" aria-hidden="true">
    <div class="hero-dots"></div>
  </div>

  <div class="hero-container">
    <div class="hero-split-grid">
      <!-- LEFT -->
      <div class="hero-content-left">
        <div class="eyebrow">
          <div class="eyebrow-dot"></div>
          <span class="eyebrow-icon">🖥️</span>
          <span class="eyebrow-text">Premium IT Solutions & Custom Software</span>
        </div>

        <h1 class="headline">
          Infrastruktur Jaringan<br>
          Sekolah, Perkantoran &<br>
          <span class="headline-grad">Aplikasi Custom</span>
        </h1>

        <p class="desc">
          Konfigin IT Solutions menghadirkan <strong>aplikasi kustom premium</strong> dan instalasi jaringan handal berlisensi sekali putus — kepemilikan penuh selamanya tanpa biaya langganan bulanan.
        </p>

        <div class="cta-row">
          @if($kontak)
            <a href="https://wa.me/{{ str_replace('-', '', filter_var($kontak->whatsapp, FILTER_SANITIZE_NUMBER_INT)) }}?text=Halo%20Konfigin,%20saya%20tertarik%20ingin%20konsultasi%20layanan%20IT%20Solutions" target="_blank" rel="noopener" class="btn-primary-branded">
              <span>💬</span> Konsultasi Jaringan & App
            </a>
          @endif
          <a href="#eservice" class="btn-secondary-branded">
            <span>⚡</span> Layanan Utama
          </a>
        </div>
        
        <div class="trust-row">
          <!-- Section Uptime<div class="trust-pill">
            <span class="tp-icon">✅</span>
            Uptime <span class="tp-val">&nbsp;99.9%</span>
          </div>
          <div class="trust-pill">
            <span class="tp-icon">🚀</span>
            Proyek <span class="tp-val">&nbsp;50+</span>
          </div>
          <div class="trust-pill">
            <span class="tp-icon">🛡️</span>
            Support <span class="tp-val">&nbsp;24/7</span>
          </div>-->
        </div>
      </div>

      <!-- RIGHT -->
      <div class="hero-visual-right">
        <!-- Float cards -->
        <div class="float-card fc-1">
          <div class="fc-icon">⚡</div>
          <div>
            <div class="fc-val">99.99%</div>
            <div class="fc-lbl">Network Uptime</div>
          </div>
        </div>
        <div class="float-card fc-2">
          <div class="fc-icon">🔒</div>
          <div>
            <div class="fc-val">SSL Active</div>
            <div class="fc-lbl">Enkripsi End-to-End</div>
          </div>
        </div>

        <!-- Dashboard -->
        <div class="dash">
          <!-- Chrome -->
          <div class="dash-chrome">
            <div class="dots">
              <div class="dot dot-r"></div>
              <div class="dot dot-y"></div>
              <div class="dot dot-g"></div>
            </div>
            <div class="addr">
              <span class="addr-lock">🔒</span>
              secure.konfigin.com
            </div>
            <div style="width:56px"></div>
          </div>

          <!-- Status -->
          <div class="dash-status">
            <div class="status-left">
              <div class="status-dot-live"></div>
              <div class="status-txt">SYSTEM STATUS: <b>ACTIVE / ONLINE</b></div>
            </div>
            <div class="status-ver">v2.4.1</div>
          </div>

          <!-- Metrics -->
          <div class="dash-metrics">
            <div class="metric">
              <div class="metric-head">Network Uptime <span class="metric-ico">🌐</span></div>
              <div class="metric-num">99.99<sup>%</sup></div>
              <div class="metric-hint">↑ Stabil 30 hari terakhir</div>
            </div>
            <div class="metric">
              <div class="metric-head">Active Sockets <span class="metric-ico">🔌</span></div>
              <div class="metric-num">16<sup> / 16</sup></div>
              <div class="metric-hint">Semua nodes aktif</div>
            </div>
          </div>

          <!-- Network visual -->
          <div class="dash-net">
            <div class="net-center">🛡️</div>
            <div class="net-node" style="top:10px;left:24px">💾</div>
            <div class="net-node" style="top:10px;right:24px">📡</div>
            <div class="net-node" style="bottom:8px;left:16px">🖥️</div>
            <div class="net-node" style="bottom:8px;right:16px">⚙️</div>
            <!-- SVG connections -->
            <svg style="position:absolute;inset:0;width:100%;height:100%;pointer-events:none" viewBox="0 0 100 100" preserveAspectRatio="none">
              <defs>
                <linearGradient id="lg" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#2563EB" stop-opacity="0.1"/>
                  <stop offset="50%" stop-color="#38BDF8" stop-opacity="0.5"/>
                  <stop offset="100%" stop-color="#2563EB" stop-opacity="0.1"/>
                </linearGradient>
              </defs>
              <line x1="12" y1="18" x2="50" y2="50" stroke="url(#lg)" stroke-width="1"/>
              <line x1="88" y1="18" x2="50" y2="50" stroke="url(#lg)" stroke-width="1"/>
              <line x1="8"  y1="82" x2="50" y2="50" stroke="url(#lg)" stroke-width="1"/>
              <line x1="92" y1="82" x2="50" y2="50" stroke="url(#lg)" stroke-width="1"/>
              <!-- Pulse dots -->
              <circle cx="50" cy="50" r="22" fill="none" stroke="rgba(37,99,235,.08)" stroke-width="1" stroke-dasharray="4 4"/>
            </svg>
          </div>

          <div class="dash-sep"></div>

          <!-- Console -->
          <div class="dash-console">
            <div class="c-line"><span class="c-tag c-ok">OK</span><span class="c-msg">Established secure connection to edge router...</span></div>
            <div class="c-line"><span class="c-tag c-info">INFO</span><span class="c-msg">Database backup generated successfully.</span></div>
            <div class="c-line"><span class="c-tag c-sec">SEC</span><span class="c-msg">Encrypted transmission SSL tunnel active.</span></div>
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
      <div class="eservice-card premium-card animate-on-scroll" id="eservice-{{ $svc->id }}">
        <div class="eservice-icon" style="background: {{ $svc->warna }}">
          <i class="{{ $svc->icon }}"></i>
        </div>
        <div style="flex:1;">
          <h3 style="font-size: 1.15rem; margin-bottom: 0.5rem; font-family: 'Plus Jakarta Sans', sans-serif;">{{ $svc->nama }}</h3>
          <p>{{ $svc->deskripsi }}</p>
        </div>
        <div class="eservice-card-actions">
          @if($svc->blog_slug)
            <a href="{{ route('blog.show', $svc->blog_slug) }}" class="btn btn-ghost btn-sm eservice-btn-more">
              <i class="fas fa-book-open"></i> Selengkapnya
            </a>
          @endif
          @if($svc->demo_url)
            <a href="{{ $svc->demo_url }}" target="_blank" rel="noopener" class="btn btn-ghost btn-sm eservice-btn-demo">
              <i class="fas fa-play-circle"></i> Demo
            </a>
          @endif
          <a href="{{ $svc->url }}" target="_blank" rel="noopener" class="btn btn-ghost btn-sm" style="border-radius: 100px;" aria-label="{{ $svc->nama }}">
            <i class="fab fa-whatsapp"></i> Hubungi Kami
          </a>
        </div>
      </div>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Stagger animations for trust-pills
  document.querySelectorAll('.trust-pill').forEach((el,i)=>{
    el.style.opacity='0';el.style.transform='translateY(10px)';
    el.style.transition=`all .45s cubic-bezier(.4,0,.2,1) ${.7+i*.08}s`;
    setTimeout(()=>{el.style.opacity='1';el.style.transform='translateY(0)'}, 50);
  });
});
</script>
@endpush

@endsection
