@extends('admin.layout')

@section('title', 'Pengaturan Umum')
@section('page_title', 'Pengaturan Profil Website')
@section('page_subtitle', 'Ubah teks hero, profil, dan identitas situs')

@section('content')
<div class="card">
  <div class="card-header">
    <h2 class="card-title">Konfigurasi Landing Page</h2>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      
      <div class="settings-grid">
        
        <!-- Identitas Utama -->
        <div class="settings-section" style="grid-column: span 2;">
          <h3 class="section-title-small"><i class="fas fa-info-circle"></i> Identitas Website</h3>
          
          <div class="form-group">
            <label class="form-label" for="site_name">Nama Situs Web</label>
            <input type="text" id="site_name" name="site_name" class="form-input" value="{{ old('site_name', $settings['site_name'] ?? '') }}" required>
          </div>
          
          <div class="form-group">
            <label class="form-label" for="site_tagline">Tagline Singkat</label>
            <input type="text" id="site_tagline" name="site_tagline" class="form-input" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}">
          </div>
          
          <div class="form-group">
            <label class="form-label" for="site_logo">Logo Website</label>
            @if(!empty($settings['site_logo']))
              <div style="margin-bottom: 1rem; background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px; display:inline-block">
                <img src="{{ asset($settings['site_logo']) }}" alt="Logo saat ini" style="max-height: 80px; display: block;">
              </div>
            @endif
            <input type="file" id="site_logo" name="site_logo" class="form-input" accept="image/png,image/jpeg,image/webp">
            <div class="form-help">Biarkan kosong jika tidak ingin mengubah logo. (Rec: PNG Transparan)</div>
          </div>
          
          <div class="form-group" style="margin-top: 1.5rem;">
            <label class="form-label" for="site_favicon">Favicon Website</label>
            @if(!empty($settings['site_favicon']))
              <div style="margin-bottom: 1rem; background: rgba(255,255,255,0.05); padding: 0.5rem; border-radius: 8px; display:inline-block">
                <img src="{{ asset($settings['site_favicon']) }}" alt="Favicon saat ini" style="max-height: 32px; display: block;">
              </div>
            @endif
            <input type="file" id="site_favicon" name="site_favicon" class="form-input" accept="image/png,image/x-icon,image/jpeg,image/webp">
            <div class="form-help">Biarkan kosong jika tidak ingin mengubah favicon. (Rec: PNG/ICO ukuran 32x32 atau 48x48)</div>
          </div>
        </div>

      </div>

      <div style="margin-top:2rem; padding-top:1.5rem; border-top:1px solid var(--border)">
        <button type="submit" class="btn btn-primary" style="padding: 0.8rem 2.5rem; font-size:1.1rem">
          <i class="fas fa-save"></i> Simpan Semua Pengaturan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
