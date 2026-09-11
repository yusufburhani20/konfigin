@extends('landing-layout')

@section('title', $site_name ?? 'Konfigin IT Solutions')

@section('content')
<main class="w-full">
<div class="flex flex-col w-full overflow-hidden">
<!-- 1. HERO SECTION (Dark Mode Preserved) -->
<div class="relative w-full text-[#dfe2ef]">
  <!-- Video Background -->
  <video class="absolute inset-0 w-full h-full object-cover -z-20" autoplay loop muted playsinline aria-hidden="true" style="object-position: center; filter: brightness(0.7);">
    <source src="{{ asset('assets/img/global_network_background_animation.mp4') }}" type="video/mp4">
  </video>
  <!-- Overlay to ensure text readability -->
  <div class="absolute inset-0 bg-[#0a0e17]/70 backdrop-blur-[2px] -z-10"></div>
  
<section class="max-w-[1240px] mx-auto px-4 sm:px-space-lg pt-28 sm:pt-32 lg:pt-24 pb-16 sm:pb-space-3xl w-full min-h-screen flex items-center">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-space-xl items-center">
<!-- Hero Copy -->
<div class="lg:col-span-7 space-y-space-md flex flex-col items-start">
<div class="inline-flex items-center gap-space-xs px-space-sm py-1.5 rounded-full bg-surface-container-high/60 backdrop-blur-md shadow-inner shadow-primary/10">
<span class="w-2 h-2 rounded-full bg-tertiary animate-ping"></span>
<span class="text-[10px] sm:text-[11px] text-tertiary uppercase tracking-wider font-semibold">PREMIUM IT SOLUTIONS &amp; CUSTOM SOFTWARE</span>
</div>
<h1 class="text-[32px] sm:text-[40px] lg:text-[56px] font-extrabold tracking-tight text-white leading-tight">
            Infrastruktur Jaringan Sekolah, Perkantoran &amp; <span class="text-primary">Aplikasi Custom</span>
</h1>
<p class="text-sm sm:text-base text-slate-200 max-w-2xl leading-relaxed">
            Konfigin IT Solutions menghadirkan aplikasi kustom premium dan instalasi jaringan handal berlisensi sekali putus â€” kepemilikan penuh selamanya tanpa biaya langganan bulanan.
          </p>
<div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-4 w-full sm:w-auto">
@if(isset($kontak) && $kontak)
<a class="relative inline-flex items-center justify-center gap-space-xs px-space-lg py-3 rounded-xl bg-primary text-on-primary font-headline-sm text-[15px] font-bold hover:bg-primary-fixed transition-all" href="https://wa.me/{{ str_replace('-', '', filter_var($kontak->whatsapp, FILTER_SANITIZE_NUMBER_INT)) }}?text=Halo%20Konfigin,%20saya%20tertarik%20ingin%20konsultasi%20layanan%20IT%20Solutions" target="_blank" rel="noopener">
<span class="material-symbols-outlined text-[20px]">hub</span>
<span>Konsultasi Jaringan &amp; App</span>
</a>
@endif
<a class="inline-flex items-center justify-center gap-space-xs px-space-lg py-3 rounded-xl bg-surface-container-high/60 backdrop-blur-md text-white hover:bg-surface-bright transition-all font-headline-sm text-[15px] font-semibold border border-slate-700/60" href="#layanan-utama">
<span>Layanan Utama</span>
<span class="material-symbols-outlined text-[18px]">arrow_downward</span>
</a>
</div>
</div>
<!-- Hero Telemetry Console Card -->
<div class="lg:col-span-5 relative w-full hidden lg:block">
<div class="relative rounded-2xl bg-[#1c1f29]/90 backdrop-blur-xl p-space-md space-y-space-sm border border-slate-600/50">
<!-- Window header bar -->
<div class="flex items-center justify-between pb-space-xs">
<div class="flex items-center gap-1.5">
<span class="w-3 h-3 rounded-full bg-error-container"></span>
<span class="w-3 h-3 rounded-full bg-secondary-container"></span>
<span class="w-3 h-3 rounded-full bg-tertiary-container"></span>
</div>
<span class="px-space-xs py-0.5 rounded bg-surface-container font-label-caps text-[10px] text-tertiary font-semibold uppercase">v2.4.1 Active</span>
</div>
<!-- Health row -->
<div class="grid grid-cols-2 gap-space-xs">
<div class="p-space-sm rounded-xl bg-surface-container space-y-1">
<div class="flex items-center justify-between">
<span class="font-label-caps text-label-caps text-slate-400 uppercase">Network Uptime</span>
<span class="material-symbols-outlined text-secondary text-[16px]">speed</span>
</div>
<div class="flex items-baseline gap-1">
<span class="font-headline-lg text-headline-lg font-bold text-white">99.99</span>
<span class="font-label-caps text-label-caps text-secondary">%</span>
</div>
<p class="font-body-sm text-body-sm text-slate-400 text-[12px]">Stabil 30 hari terakhir</p>
</div>
<div class="p-space-sm rounded-xl bg-surface-container space-y-1">
<div class="flex items-center justify-between">
<span class="font-label-caps text-label-caps text-slate-400 uppercase">Active Sockets</span>
<span class="material-symbols-outlined text-tertiary text-[16px]">sensors</span>
</div>
<div class="flex items-baseline gap-1">
<span class="font-headline-lg text-headline-lg font-bold text-white">16</span>
<span class="font-label-caps text-label-caps text-slate-400">/ 16</span>
</div>
<p class="font-body-sm text-body-sm text-tertiary text-[12px]">Semua nodes aktif</p>
</div>
</div>
<!-- Topology visual canvas -->
<div class="p-space-sm rounded-xl bg-surface-container-lowest relative overflow-hidden space-y-2 border border-slate-800">
<div class="flex items-center justify-between">
<div class="flex items-center gap-space-2xs">
<span class="w-2 h-2 rounded-full bg-secondary"></span>
<span class="font-label-caps text-label-caps text-slate-400 uppercase">Topology Visualizer</span>
</div>
<span class="font-code-telemetry text-code-telemetry text-tertiary text-[11px]">Latency: 12ms</span>
</div>
<!-- SVG Network Node graph -->
<div class="w-full h-24 flex items-center justify-center">
<svg class="w-full h-full stroke-current text-primary-container" fill="none" viewbox="0 0 340 70">
<path class="opacity-40" d="M 30 35 Q 90 10, 170 35 T 310 35" stroke-dasharray="4 4" stroke-width="1.5"></path>
<line class="text-primary" stroke-width="1.5" x1="30" x2="95" y1="35" y2="20"></line>
<line class="text-secondary" stroke-width="1.5" x1="95" x2="170" y1="20" y2="35"></line>
<line class="text-primary" stroke-width="1.5" x1="170" x2="245" y1="35" y2="50"></line>
<line class="text-tertiary" stroke-width="1.5" x1="245" x2="310" y1="50" y2="35"></line>
<!-- Nodes -->
<circle class="fill-surface-container-high text-primary stroke-current" cx="30" cy="35" r="7" stroke-width="2"></circle>
<circle class="fill-secondary" cx="95" cy="20" r="5"></circle>
<circle class="fill-surface-container-highest text-secondary stroke-current" cx="170" cy="35" r="9" stroke-width="2"></circle>
<circle class="fill-primary" cx="245" cy="50" r="5"></circle>
<circle class="fill-surface-container-high text-tertiary stroke-current" cx="310" cy="35" r="7" stroke-width="2"></circle>
</svg>
</div>
<div class="flex items-center justify-between text-[11px] font-code-telemetry text-slate-400 px-1">
<span>GATEWAY [MK-CCR2004]</span>
<span>CORE-SWITCH</span>
<span>APP-ENGINE</span>
</div>
</div>
<!-- Terminal log simulation -->
<div class="p-space-sm rounded-xl bg-surface-container font-code-telemetry text-code-telemetry text-[12px] space-y-1">
<div class="flex items-center gap-space-2xs text-tertiary">
<span class="material-symbols-outlined text-[14px]">check_circle</span>
<span>Established secure connection to edge router...</span>
</div>
<div class="flex items-center gap-space-2xs text-secondary">
<span class="material-symbols-outlined text-[14px]">sync_saved_locally</span>
<span>Database backup generated successfully [142MB].</span>
</div>
<div class="flex items-center justify-between text-slate-400 pt-1 text-[11px]">
<span class="flex items-center gap-1">
<span class="material-symbols-outlined text-primary text-[14px]">lock</span>
                  SSL End-to-End Encrypted (TLS 1.3)
                </span>
<span class="text-tertiary font-bold">STABLE</span>
</div>
</div>
</div>
</div>
</div>

</section>
</div>

<!-- 2. LAYANAN UTAMA SECTION (LIGHT MODE) -->
<section class="w-full bg-white py-space-4xl relative border-b border-slate-200" id="layanan-utama">
<div class="max-w-[1240px] mx-auto px-space-lg">
<div class="text-center max-w-3xl mx-auto space-y-space-xs mb-space-3xl">
<div class="inline-flex items-center gap-space-2xs px-3 py-1 rounded-full bg-sky-50 border border-sky-100">
<span class="material-symbols-outlined text-sky-600 text-[16px]">apps</span>
<span class="font-label-caps text-label-caps text-sky-700 font-semibold uppercase">LAYANAN UTAMA</span>
</div>
<h2 class="font-headline-xl text-headline-xl font-bold text-slate-900">Paket Software &amp; IT Solutions</h2>
<p class="font-body-lg text-body-lg text-slate-600">Pilih layanan solusi digital terintegrasi yang dirancang untuk mempercepat pertumbuhan bisnis Anda.</p>
</div>
<!-- Grid Dinamis E-Service -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-lg">
  @foreach($eservice as $svc)
  @php
    $colorClass = 'sky';
    if($loop->index % 3 == 1) $colorClass = 'cyan';
    if($loop->index % 3 == 2) $colorClass = 'emerald';
    
    // Check if it's the 4th item (index 3) to make it span 2 columns like in the design
    $colSpan = ($loop->index == 3) ? 'md:col-span-1 lg:col-span-2' : '';
  @endphp
  <div class="group p-space-xl rounded-2xl bg-white border border-slate-200 hover:border-{{$colorClass}}-300 hover:shadow-xl transition-all duration-300 flex flex-col justify-between shadow-sm relative overflow-hidden {{ $colSpan }}">
    <div class="space-y-space-md">
      <div class="w-14 h-14 rounded-xl flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform" style="background-color: {{ $svc->warna }}15; color: {{ $svc->warna }}; border: 1px solid {{ $svc->warna }}30;">
        <i class="{{ $svc->icon }} text-[30px]"></i>
      </div>
      <div>
        <span class="font-label-caps text-label-caps font-semibold uppercase" style="color: {{ $svc->warna }}">{{ $svc->nama }}</span>
        <h3 class="font-headline-md text-headline-md font-bold text-slate-900 mt-1">{{ $svc->nama }}</h3>
      </div>
      <p class="font-body-md text-body-md text-slate-600 leading-relaxed">{{ $svc->deskripsi }}</p>
    </div>
    
    <div class="pt-space-lg space-y-space-xs flex flex-col mt-4">
      @if($svc->blog_slug || $svc->demo_url)
      <div class="flex items-center gap-space-xs">
        @if($svc->blog_slug)
          @php
            $moreUrl = $svc->blog_slug;
            $isExternal = str_starts_with($moreUrl, 'http://') || str_starts_with($moreUrl, 'https://');
            if (!$isExternal && !str_starts_with($moreUrl, '#') && !str_starts_with($moreUrl, 'mailto:') && !str_starts_with($moreUrl, 'tel:')) {
                $moreUrl = url($moreUrl);
            }
          @endphp
          <a class="flex-1 py-2.5 rounded-lg bg-slate-100 hover:bg-slate-800 hover:text-sky-600 text-center font-headline-sm text-[13px] font-semibold text-slate-800 transition-colors" href="{{ $moreUrl }}" @if($isExternal) target="_blank" rel="noopener" @endif>
            Selengkapnya
          </a>
        @endif
        @if($svc->demo_url)
          <a class="px-4 py-2.5 rounded-lg text-center font-headline-sm text-[13px] font-semibold transition-colors border" style="background-color: {{ $svc->warna }}10; color: {{ $svc->warna }}; border-color: {{ $svc->warna }}30;" href="{{ $svc->demo_url }}" target="_blank" rel="noopener">
            Demo
          </a>
        @endif
      </div>
      @endif
      <a class="w-full block py-2.5 rounded-lg text-center font-body-sm text-[13px] font-semibold transition-colors border shadow-sm" style="background-color: {{ $svc->warna }}; color: white; border-color: {{ $svc->warna }};" href="{{ $svc->url }}" target="_blank" rel="noopener">
        <i class="fab fa-whatsapp mr-1"></i> Hubungi Kami
      </a>
    </div>
  </div>
  @endforeach
</div>
</div>
</section>
<!-- 3. KENAPA PILIH KONFIGIN SECTION (LIGHT MODE) -->
<section class="w-full py-space-4xl relative bg-slate-50/70 border-b border-slate-200" id="keunggulan">
<div class="max-w-[1240px] mx-auto px-space-lg">
<div class="text-center max-w-2xl mx-auto space-y-space-xs mb-space-3xl">
<div class="inline-flex items-center gap-space-2xs px-3 py-1 rounded-full bg-sky-50 border border-sky-100">
<span class="material-symbols-outlined text-sky-600 text-[16px]">verified_user</span>
<span class="font-label-caps text-label-caps text-sky-700 font-semibold uppercase">KEUNGGULAN OPERASIONAL</span>
</div>
<h2 class="font-headline-xl text-headline-xl font-bold text-slate-900">Kenapa Pilih Konfigin?</h2>
<p class="font-body-lg text-body-lg text-slate-600">Komitmen penuh kami dalam memberikan keandalan teknologi terbaik untuk kesuksesan jangka panjang Anda.</p>
</div>
<!-- Keunggulan Dinamis Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-space-md">
  @foreach($keunggulan as $k)
  @php
    $colorClass = 'sky';
    if($loop->index % 3 == 1) $colorClass = 'cyan';
    if($loop->index % 3 == 2) $colorClass = 'emerald';
  @endphp
  <div class="p-space-lg rounded-2xl bg-white border border-slate-200 hover:border-{{$colorClass}}-300 hover:shadow-md transition-all group space-y-space-xs shadow-sm flex flex-col items-start text-left">
    <div class="w-12 h-12 rounded-xl bg-{{$colorClass}}-50 border border-{{$colorClass}}-100 flex items-center justify-center text-{{$colorClass}}-600 group-hover:scale-110 transition-transform mb-2">
      <i class="{{ $k->icon }} text-[24px]"></i>
    </div>
    <h3 class="font-headline-sm text-headline-sm font-semibold text-slate-900">{{ $k->judul }}</h3>
    <p class="font-body-sm text-body-sm text-slate-600 leading-relaxed">{{ $k->deskripsi }}</p>
  </div>
  @endforeach
</div>
</div>
</section>
<!-- 4. PAKET SOFTWARE UNTUK SEMUA SKALA BISNIS (LIGHT PRICING) -->
<section class="w-full bg-white py-space-4xl relative border-b border-slate-200" id="paket-harga">
<div class="max-w-[1240px] mx-auto px-space-lg">
<div class="text-center max-w-3xl mx-auto space-y-space-xs mb-space-3xl">
<div class="inline-flex items-center gap-space-2xs px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100">
<span class="material-symbols-outlined text-emerald-600 text-[16px]">sell</span>
<span class="font-label-caps text-label-caps text-emerald-700 font-semibold uppercase">TRANSPARANSI INVESTASI</span>
</div>
<h2 class="font-headline-xl text-headline-xl font-bold text-slate-900">Paket Harga &amp; Solusi</h2>
<p class="font-body-lg text-body-lg text-slate-600">Pilih model lisensi sekali putus yang proporsional dengan proyeksi pertumbuhan bisnis dan volume tim Anda.</p>
</div>
<!-- Pricing Dinamis Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-space-lg items-stretch">
  @foreach($kurikulum as $pkg)
  @php
    $isPopular = !empty($pkg->badge) && strtolower($pkg->badge) === 'populer';
    $waLink = $pkg->roadmap_url;
    if (empty($waLink) || $waLink === '#') {
        $waLink = isset($kontak) && $kontak ? 'https://wa.me/' . str_replace('-', '', filter_var($kontak->whatsapp, FILTER_SANITIZE_NUMBER_INT)) . '?text=Halo%20Konfigin,%20saya%20tertarik%20dengan%20' . rawurlencode($pkg->nama_mapel) : '#';
    }
  @endphp
  
  @if($isPopular)
  <!-- Popular Tier -->
  <div class="rounded-2xl p-space-xl bg-gradient-to-b from-sky-600 to-sky-700 text-white flex flex-col justify-between shadow-xl relative transform lg:-translate-y-2 ring-4 ring-sky-200/70">
    <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-space-sm py-1 rounded-full bg-amber-400 text-slate-900 font-label-caps text-[11px] uppercase tracking-wider font-extrabold shadow-md">
      {{ $pkg->badge }}
    </div>
    <div class="space-y-space-md">
      <div>
        <h3 class="font-headline-md text-headline-md font-bold text-slate-900">{{ $pkg->nama_mapel }}</h3>
      </div>
      <div>
        <div class="flex items-baseline gap-1 mt-2">
          <span class="font-display-hero text-[34px] font-extrabold text-white leading-none">{{ $pkg->harga }}</span>
        </div>
        <span class="font-label-caps text-label-caps text-sky-200 uppercase mt-1 inline-block">/ Sekali Bayar</span>
      </div>
      <div class="space-y-space-xs pt-space-xs mt-4">
        @if(!empty($pkg->fitur))
          @foreach(explode("\n", str_replace("\r", "", $pkg->fitur)) as $feature)
            @php
              $feature = trim($feature);
              if (empty($feature)) continue;
              $isCrossed = str_starts_with($feature, '-');
              $featureText = $isCrossed ? ltrim($feature, '- ') : $feature;
            @endphp
            <div class="flex items-start gap-space-2xs text-body-sm font-body-sm text-white font-medium {{ $isCrossed ? 'opacity-50 line-through' : '' }}">
              <span class="material-symbols-outlined text-white text-[18px] shrink-0 mt-0.5">{{ $isCrossed ? 'cancel' : 'check_circle' }}</span>
              <span>{{ $featureText }}</span>
            </div>
          @endforeach
        @endif
      </div>
    </div>
    <div class="pt-space-xl mt-6">
      <a class="w-full block py-3 rounded-xl bg-white text-sky-700 hover:bg-slate-50 text-center font-headline-sm text-[15px] font-extrabold shadow-md hover:shadow-lg transition-all" href="{{ $waLink }}" target="_blank" rel="noopener">
        Pilih Paket
      </a>
    </div>
  </div>
  @else
  <!-- Standard Tier -->
  <div class="rounded-2xl p-space-xl bg-white border border-slate-200 flex flex-col justify-between shadow-sm hover:shadow-md transition-all relative">
    @if(!empty($pkg->badge))
      <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 px-space-sm py-1 rounded-full bg-slate-200 text-slate-800 font-label-caps text-[11px] uppercase tracking-wider font-extrabold shadow-sm border border-slate-300">
        {{ $pkg->badge }}
      </div>
    @endif
    <div class="space-y-space-md">
      <div>
        <h3 class="font-headline-md text-headline-md font-bold text-slate-900 mt-2">{{ $pkg->nama_mapel }}</h3>
      </div>
      <div>
        <div class="flex items-baseline gap-1 mt-2">
          <span class="font-display-hero text-[34px] font-extrabold text-slate-900 leading-none">{{ $pkg->harga }}</span>
        </div>
        <span class="font-label-caps text-label-caps text-slate-500 uppercase mt-1 inline-block">/ Sekali Bayar</span>
      </div>
      <div class="space-y-space-xs pt-space-xs mt-4">
        @if(!empty($pkg->fitur))
          @foreach(explode("\n", str_replace("\r", "", $pkg->fitur)) as $feature)
            @php
              $feature = trim($feature);
              if (empty($feature)) continue;
              $isCrossed = str_starts_with($feature, '-');
              $featureText = $isCrossed ? ltrim($feature, '- ') : $feature;
            @endphp
            <div class="flex items-start gap-space-2xs text-body-sm font-body-sm text-slate-700 {{ $isCrossed ? 'opacity-50 line-through' : '' }}">
              <span class="material-symbols-outlined {{ $isCrossed ? 'text-slate-500' : 'text-emerald-600' }} text-[18px] shrink-0 mt-0.5">{{ $isCrossed ? 'cancel' : 'check_circle' }}</span>
              <span>{{ $featureText }}</span>
            </div>
          @endforeach
        @endif
      </div>
    </div>
    <div class="pt-space-xl mt-6">
      <a class="w-full block py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-center font-headline-sm text-[14px] font-bold text-slate-800 transition-colors border border-slate-200" href="{{ $waLink }}" target="_blank" rel="noopener">
        Pilih Paket
      </a>
    </div>
  </div>
  @endif
  
  @endforeach
</div>
</div>
</section>

<!-- PORTOFOLIO SECTION -->
<section class="w-full bg-slate-50 py-space-4xl relative border-b border-slate-200" id="galeri">
<div class="max-w-[1240px] mx-auto px-space-lg">
<div class="text-center max-w-3xl mx-auto space-y-space-xs mb-space-3xl">
<div class="inline-flex items-center gap-space-2xs px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100">
<span class="material-symbols-outlined text-indigo-600 text-[16px]">gallery_thumbnail</span>
<span class="font-label-caps text-label-caps text-indigo-700 font-semibold uppercase">KARYA KAMI</span>
</div>
<h2 class="font-headline-xl text-headline-xl font-bold text-slate-900">Portofolio & Project Kami</h2>
<p class="font-body-lg text-body-lg text-slate-600">Berbagai implementasi sistem dan infrastruktur jaringan yang telah sukses kami kerjakan.</p>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-space-lg">
  @foreach($galeri->take(6) as $item)
  <div class="group rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-xl transition-all border border-slate-200">
    <div class="aspect-video w-full overflow-hidden bg-slate-100">
      <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
    </div>
    <div class="p-space-md">
      <h3 class="font-headline-sm text-headline-sm font-bold text-slate-900">{{ $item->judul }}</h3>
      @if($item->deskripsi)
      <p class="font-body-sm text-body-sm text-slate-600 mt-2 line-clamp-2">{{ $item->deskripsi }}</p>
      @endif
    </div>
  </div>
  @endforeach
</div>
<div class="mt-space-2xl text-center">
  <a href="{{ route('portofolio.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-slate-900 hover:bg-slate-800 text-white font-headline-sm text-[15px] transition-all">
    Lihat Semua Portofolio <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
  </a>
</div>
</div>
</section>

<!-- 5. DUAL CTA SECTION -->
<section id="kontak-konsultasi" class="w-full bg-slate-50 py-space-4xl relative border-b border-slate-200">
<div class="max-w-[1240px] mx-auto px-space-lg">
<div class="text-center max-w-3xl mx-auto space-y-space-xs mb-space-3xl">
<div class="inline-flex items-center gap-space-2xs px-3 py-1 rounded-full bg-sky-50 border border-sky-100">
<span class="material-symbols-outlined text-sky-600 text-[16px]">contact_support</span>
<span class="font-label-caps text-label-caps text-sky-700 font-semibold uppercase">KONTAK KAMI</span>
</div>
<h2 class="font-headline-xl text-headline-xl font-bold text-slate-900">Siap Punya Software Profesional?</h2>
<p class="font-body-lg text-body-lg text-slate-600">Konsultasikan kebutuhan IT Solutions atau instalasi jaringan Anda secara gratis bersama tim ahli kami.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-space-lg items-stretch">
<!-- WhatsApp Priority Card -->
<div class="p-space-xl rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 text-white flex flex-col justify-between shadow-xl relative overflow-hidden">
<div class="space-y-space-sm">
<div class="w-12 h-12 rounded-xl bg-white/15 backdrop-blur flex items-center justify-center">
<span class="material-symbols-outlined text-[28px] text-white">chat</span>
</div>
<h3 class="font-headline-md text-headline-md font-bold text-slate-900">Konsultasi Kilat via WhatsApp</h3>
<p class="font-body-md text-body-md text-emerald-50 leading-relaxed">
              Hubungi tim technical consultant kami secara langsung untuk respon cepat seputar harga, penyesuaian modul fitur, dan survei teknis lokasi instalasi jaringan.
            </p>
</div>
<div class="pt-space-xl mt-6">
@if(isset($kontak) && $kontak)
<a class="inline-flex items-center justify-center gap-space-xs w-full py-3.5 rounded-xl bg-white hover:bg-emerald-50 text-emerald-800 font-headline-sm text-[15px] font-bold shadow-md hover:shadow-lg transition-all" href="https://wa.me/{{ str_replace('-', '', filter_var($kontak->whatsapp, FILTER_SANITIZE_NUMBER_INT)) }}?text=Halo%20Konfigin,%20saya%20tertarik%20ingin%20konsultasi%20layanan%20IT%20Solutions" rel="noopener noreferrer" target="_blank">
<span class="material-symbols-outlined text-[20px]">send</span>
<span>Hubungi WhatsApp ({{ $kontak->whatsapp }})</span>
</a>
@endif
</div>
</div>
<!-- Official RFP / Email Card -->
<div class="p-space-xl rounded-2xl bg-gradient-to-br from-sky-600 to-blue-700 text-white flex flex-col justify-between shadow-xl relative overflow-hidden">
<div class="space-y-space-sm">
<div class="w-12 h-12 rounded-xl bg-white/15 backdrop-blur flex items-center justify-center">
<span class="material-symbols-outlined text-[28px] text-white">mail</span>
</div>
<h3 class="font-headline-md text-headline-md font-bold text-slate-900">Kirim Penawaran via Email</h3>
<p class="font-body-md text-body-md text-sky-50 leading-relaxed">
              Ajukan dokumen Kerangka Acuan Kerja (KAK), spesifikasi teknis, atau permintaan penawaran harga resmi (RFP) langsung ke tim engineering kami.
            </p>
</div>
<div class="pt-space-xl mt-6">
@if(isset($kontak) && $kontak)
<a class="inline-flex items-center justify-center gap-space-xs w-full py-3.5 rounded-xl bg-white hover:bg-sky-50 text-sky-800 font-headline-sm text-[15px] font-bold shadow-md hover:shadow-lg transition-all" href="mailto:{{ $kontak->email }}">
<span class="material-symbols-outlined text-[20px]">drafts</span>
<span>Kirim Email Resmi ({{ $kontak->email }})</span>
</a>
@endif
</div>
</div>
</div>
</div>
</section>
</div>
</main>
@endsection
