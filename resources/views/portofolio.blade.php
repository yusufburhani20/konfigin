@extends('landing-layout')

@section('title', 'Portofolio - ' . ($site_name ?? 'Konfigin IT Solutions'))

@section('content')
<main class="w-full pt-20">
  
  <!-- HERO PORTOFOLIO -->
  <section class="w-full bg-slate-50 py-space-4xl relative border-b border-slate-200">
    <div class="absolute inset-0 bg-gradient-to-b from-sky-50 to-white -z-10"></div>
    <div class="max-w-[1240px] mx-auto px-space-lg text-center mt-12">
      <div class="inline-flex items-center gap-space-2xs px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 mb-6">
        <span class="material-symbols-outlined text-indigo-600 text-[16px]">gallery_thumbnail</span>
        <span class="font-label-caps text-label-caps text-indigo-700 font-semibold uppercase">KARYA KAMI</span>
      </div>
      <h1 class="font-display-hero text-[40px] md:text-[56px] font-extrabold tracking-tight text-slate-900 leading-tight">
        Portofolio & Project
      </h1>
      <p class="font-body-lg text-body-lg text-slate-600 max-w-2xl mx-auto mt-4">
        Eksplorasi berbagai implementasi sistem, pengembangan perangkat lunak, dan infrastruktur jaringan yang telah sukses kami selesaikan.
      </p>
    </div>
  </section>

  <!-- LIST PORTOFOLIO -->
  <section class="w-full bg-white py-space-4xl relative" id="galeri-list">
    <div class="max-w-[1240px] mx-auto px-space-lg">
      @if($galeri->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-space-xl">
          @foreach($galeri as $item)
          <div class="group rounded-2xl overflow-hidden bg-white shadow-sm hover:shadow-xl transition-all border border-slate-200 flex flex-col h-full">
            <div class="aspect-[4/3] w-full overflow-hidden bg-slate-100 relative">
              <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
              <div class="absolute inset-0 bg-slate-900/10 group-hover:bg-transparent transition-colors"></div>
            </div>
            <div class="p-space-lg flex flex-col flex-1">
              <h3 class="font-headline-md text-[20px] font-bold text-slate-900">{{ $item->judul }}</h3>
              @if($item->deskripsi)
              <p class="font-body-md text-slate-600 mt-3 leading-relaxed flex-1">{{ $item->deskripsi }}</p>
              @endif
              <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-400">{{ $item->created_at->format('M Y') }}</span>
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

</main>
@endsection
