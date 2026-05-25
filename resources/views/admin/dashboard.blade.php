@extends('admin.layout')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Selamat datang, ' . session('admin_nama', 'Admin'))

@section('content')
<div class="stats-grid">
  <div class="stat-card animate-on-scroll">
    <div class="stat-icon" style="background: linear-gradient(135deg, #0072ff, #0056b3)">
      <i class="fas fa-box-open"></i>
    </div>
    <div class="stat-info">
      <div class="number">{{ $total_kurikulum }}</div>
      <div class="label">Produk Aplikasi</div>
    </div>
  </div>
  <div class="stat-card animate-on-scroll">
    <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9)">
      <i class="fas fa-images"></i>
    </div>
    <div class="stat-info">
      <div class="number">{{ $total_galeri }}</div>
      <div class="label">Galeri &amp; Portofolio</div>
    </div>
  </div>
  <div class="stat-card animate-on-scroll">
    <div class="stat-icon" style="background: linear-gradient(135deg, #00c6ff, #0099c7)">
      <i class="fas fa-cogs"></i>
    </div>
    <div class="stat-info">
      <div class="number">{{ $total_eservice }}</div>
      <div class="label">Layanan IT</div>
    </div>
  </div>
  <div class="stat-card animate-on-scroll">
    <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706)">
      <i class="fas fa-star"></i>
    </div>
    <div class="stat-info">
      <div class="number">{{ $total_keunggulan }}</div>
      <div class="label">Keunggulan</div>
    </div>
  </div>
</div>

<div class="quick-actions">
  <h2 class="section-heading">Akses Cepat</h2>
  <div class="quick-grid">
    <a href="{{ route('admin.posts.index') }}" class="quick-card" id="quick-posts-list" style="border-color: rgba(139, 92, 246, 0.25);">
      <i class="fas fa-newspaper" style="color: #8b5cf6;"></i>
      <span>Daftar Post</span>
    </a>
    <a href="{{ route('admin.posts.create') }}" class="quick-card" id="quick-posts-create" style="border-color: rgba(16, 185, 129, 0.25);">
      <i class="fas fa-plus-circle" style="color: #10b981;"></i>
      <span>Tulis Post</span>
    </a>
    <a href="{{ route('admin.settings.index') }}" class="quick-card" id="quick-settings">
      <i class="fas fa-cog"></i>
      <span>Pengaturan</span>
    </a>
    <a href="{{ route('admin.kurikulum.index') }}" class="quick-card" id="quick-kurikulum">
      <i class="fas fa-box-open"></i>
      <span>Produk</span>
    </a>
    <a href="{{ route('admin.galeri.index') }}" class="quick-card" id="quick-galeri">
      <i class="fas fa-images"></i>
      <span>Galeri</span>
    </a>
    <a href="{{ route('admin.eservice.index') }}" class="quick-card" id="quick-eservice">
      <i class="fas fa-cogs"></i>
      <span>Layanan IT</span>
    </a>
    <a href="{{ route('admin.keunggulan.index') }}" class="quick-card" id="quick-keunggulan">
      <i class="fas fa-star"></i>
      <span>Keunggulan</span>
    </a>
    <a href="{{ route('admin.kontak.edit') }}" class="quick-card" id="quick-kontak">
      <i class="fas fa-phone-alt"></i>
      <span>Kontak</span>
    </a>
  </div>
</div>
@endsection
