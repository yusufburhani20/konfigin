@extends('landing-layout')

@section('title', 'Portofolio - ' . ($site_name ?? 'Konfigin IT Solutions'))

@section('content')
<main class="w-full">
  
  <!-- HERO PORTOFOLIO -->
  <section class="w-full relative text-[#dfe2ef] border-b border-slate-800/50" style="background-color: #0a0e17;">
    <div class="max-w-[1240px] mx-auto px-4 sm:px-space-lg pt-32 sm:pt-36 lg:pt-32 pb-16 sm:pb-24 text-center">
      <div class="inline-flex items-center gap-space-2xs px-3 py-1.5 rounded-full bg-surface-container-high/60 backdrop-blur-md shadow-inner shadow-primary/10 mb-6">
        <span class="material-symbols-outlined text-tertiary text-[16px]">gallery_thumbnail</span>
        <span class="text-[11px] text-tertiary font-semibold uppercase tracking-wider">KARYA KAMI</span>
      </div>
      <h1 class="font-display-hero text-[40px] md:text-[56px] font-extrabold tracking-tight text-white leading-tight">
        Portofolio & Project
      </h1>
      <p class="font-body-lg text-body-lg text-slate-200 max-w-2xl mx-auto mt-4">
        Eksplorasi berbagai implementasi sistem, pengembangan perangkat lunak, dan infrastruktur jaringan yang telah sukses kami selesaikan.
      </p>
    </div>
  </section>

  <!-- LIST PORTOFOLIO -->
  <section class="w-full bg-white py-space-4xl relative" id="galeri-list">
    <div class="max-w-[1240px] mx-auto px-space-lg">
      @if($galeri->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-xl">
          @foreach($galeri as $index => $item)
          <div class="group rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-xl transition-all border border-slate-200 flex flex-col h-full cursor-pointer" onclick="openLightbox({{ $index }})">
            <div class="aspect-[4/3] w-full overflow-hidden bg-slate-100 relative">
              <img src="{{ asset($item->foto_url) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
              <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-slate-900/40 transition-colors flex items-center justify-center">
                  <span class="material-symbols-outlined text-white text-[48px] opacity-0 group-hover:opacity-100 transition-opacity transform scale-50 group-hover:scale-100 duration-300">visibility</span>
              </div>
            </div>
            <div class="p-space-lg flex flex-col flex-1">
              <h3 class="font-headline-md text-[20px] font-bold text-slate-900">{{ $item->judul }}</h3>
              @if($item->deskripsi)
              <p class="font-body-md text-slate-600 mt-3 leading-relaxed flex-1 line-clamp-3">{{ $item->deskripsi }}</p>
              @endif
              <div class="mt-4 text-sky-600 font-semibold text-sm flex items-center gap-1 group-hover:text-sky-700">
                Lihat Detail <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      @else
        <div class="text-center py-20 bg-slate-50 rounded-2xl border border-slate-200 border-dashed">
          <span class="material-symbols-outlined text-[48px] text-slate-300">image_not_supported</span>
          <h3 class="font-headline-sm text-slate-600 mt-4">Belum ada portofolio yang ditambahkan.</h3>
        </div>
      @endif
      
      <div class="mt-space-4xl text-center">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-headline-sm text-[15px] transition-all">
          <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali ke Beranda
        </a>
      </div>
    </div>
  </section>

  <!-- LIGHTBOX MODAL -->
  <div id="lightbox" class="fixed inset-0 z-[9999] bg-slate-900/95 opacity-0 pointer-events-none transition-opacity duration-300 flex flex-col backdrop-blur-sm">
      <div class="flex justify-between items-center p-4 md:p-6 text-white absolute top-0 w-full z-10">
          <div class="text-sm font-semibold tracking-wider text-slate-400">
              <span id="lb-current">1</span> / <span id="lb-total">{{ $galeri->count() }}</span>
          </div>
          <button onclick="closeLightbox()" class="text-white hover:text-slate-300 transition-colors bg-slate-800/50 hover:bg-slate-700 p-2 rounded-full backdrop-blur-md">
              <span class="material-symbols-outlined text-[28px] block">close</span>
          </button>
      </div>
      
      <div class="flex-1 flex items-center justify-center p-4 md:p-12 relative overflow-hidden h-full w-full">
          <!-- Prev Button -->
          <button onclick="prevImage()" class="absolute left-4 md:left-8 z-10 text-white hover:text-sky-400 bg-slate-800/50 hover:bg-slate-800 p-3 md:p-4 rounded-full backdrop-blur-md transition-all shadow-lg transform hover:scale-110">
              <span class="material-symbols-outlined text-[32px] block">chevron_left</span>
          </button>
          
          <div class="w-full max-w-6xl h-full flex flex-col lg:flex-row bg-slate-800 rounded-2xl overflow-hidden shadow-2xl relative mt-12 md:mt-0 max-h-[85vh]">
              <!-- Image Container -->
              <div class="w-full lg:w-2/3 h-64 lg:h-full bg-slate-950 flex items-center justify-center relative">
                  <img id="lb-img" src="" class="w-full h-full object-contain p-2" alt="Project Image">
                  
                  <!-- Loading spinner overlay -->
                  <div id="lb-loader" class="absolute inset-0 flex items-center justify-center bg-slate-950/80 transition-opacity">
                      <span class="material-symbols-outlined text-white text-[48px] animate-spin">progress_activity</span>
                  </div>
              </div>
              <!-- Content Container -->
              <div class="w-full lg:w-1/3 p-6 md:p-8 flex flex-col h-auto lg:h-full overflow-y-auto custom-scrollbar bg-slate-800">
                  <h2 id="lb-title" class="font-headline-lg text-2xl md:text-3xl font-bold text-white mb-2 leading-tight"></h2>
                  <div class="w-12 h-1 bg-sky-500 rounded-full mb-6"></div>
                  <div id="lb-desc" class="font-body-md text-slate-300 leading-relaxed whitespace-pre-wrap flex-1 text-sm md:text-base"></div>
                  <div class="mt-8 pt-6 border-t border-slate-700">
                      <a id="lb-link" href="#" target="_blank" class="inline-flex items-center justify-center w-full gap-2 px-6 py-3.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-semibold transition-colors">
                          <span class="material-symbols-outlined text-[20px]">open_in_new</span> Selengkapnya
                      </a>
                  </div>
              </div>
          </div>

          <!-- Next Button -->
          <button onclick="nextImage()" class="absolute right-4 md:right-8 z-10 text-white hover:text-sky-400 bg-slate-800/50 hover:bg-slate-800 p-3 md:p-4 rounded-full backdrop-blur-md transition-all shadow-lg transform hover:scale-110">
              <span class="material-symbols-outlined text-[32px] block">chevron_right</span>
          </button>
      </div>
  </div>
</main>

@endsection

@push('scripts')
<style>
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent; 
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: #475569; 
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: #64748b; 
}
</style>
@php
    $galeriArray = $galeri->map(function($item) { 
        return [
            'judul' => $item->judul,
            'deskripsi' => $item->deskripsi ?? 'Tidak ada deskripsi tambahan untuk proyek ini.',
            'foto_url' => asset($item->foto_url),
            'instagram_url' => $item->instagram_url
        ];
    })->toArray();
@endphp
<script>
    const galeriData = @json($galeriArray);
    
    let currentIndex = 0;
    const lightbox = document.getElementById('lightbox');
    const lbImg = document.getElementById('lb-img');
    const lbTitle = document.getElementById('lb-title');
    const lbDesc = document.getElementById('lb-desc');
    const lbLink = document.getElementById('lb-link');
    const lbCurrent = document.getElementById('lb-current');
    const lbLoader = document.getElementById('lb-loader');
    
    function openLightbox(index) {
        currentIndex = index;
        updateLightboxContent();
        
        lightbox.classList.remove('opacity-0', 'pointer-events-none');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }
    
    function closeLightbox() {
        lightbox.classList.add('opacity-0', 'pointer-events-none');
        document.body.style.overflow = '';
    }
    
    function prevImage() {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : galeriData.length - 1;
        updateLightboxContent();
    }
    
    function nextImage() {
        currentIndex = (currentIndex < galeriData.length - 1) ? currentIndex + 1 : 0;
        updateLightboxContent();
    }
    
    function updateLightboxContent() {
        const item = galeriData[currentIndex];
        
        // Show loader
        lbLoader.style.opacity = '1';
        
        lbTitle.innerText = item.judul || 'Proyek Tanpa Judul';
        lbDesc.innerText = item.deskripsi;
        lbCurrent.innerText = currentIndex + 1;
        
        if (item.instagram_url && item.instagram_url !== '#') {
            lbLink.href = item.instagram_url;
            lbLink.style.display = 'inline-flex';
        } else {
            lbLink.style.display = 'none';
        }
        
        // Preload image
        const img = new Image();
        img.onload = function() {
            lbImg.src = this.src;
            lbLoader.style.opacity = '0';
        };
        img.src = item.foto_url;
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (lightbox.classList.contains('opacity-0')) return;
        
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'ArrowRight') nextImage();
    });
</script>
@endpush
