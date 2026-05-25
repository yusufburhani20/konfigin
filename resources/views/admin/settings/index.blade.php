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
        <div class="settings-section">
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
            <label class="form-label" for="instagram_username">Username Instagram Jurusan</label>
            <div style="display:flex; align-items:center; gap:0.5rem">
              <span style="background:var(--dark-surface); padding:10px; border-radius:8px; border:1px solid var(--border)">@</span>
              <input type="text" id="instagram_username" name="instagram_username" class="form-input" value="{{ old('instagram_username', $settings['instagram_username'] ?? '') }}" placeholder="contoh: santri_networkers" style="flex:1">
            </div>
            <div class="form-help">Digunakan untuk profil Galeri.</div>
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
        </div>

        <!-- Section Hero & Profil -->
        <div class="settings-section">
          <h3 class="section-title-small"><i class="fas fa-home"></i> Section Hero & Tentang Kami</h3>

          <div class="form-group">
            <label class="form-label" for="hero_title">Judul Utama (Hero Banner)</label>
            <input type="text" id="hero_title" name="hero_title" class="form-input" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}">
            <div class="form-help">Teks besar yang muncul pertama kali.</div>
          </div>

          <div class="form-group">
            <label class="form-label" for="hero_subtitle">Sub Judul (Hero Banner)</label>
            <textarea id="hero_subtitle" name="hero_subtitle" class="form-input" rows="3">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
            <div class="form-help">Teks deskripsi di bawah judul utama.</div>
          </div>

          <div class="form-group">
            <label class="form-label" for="profil_text">Teks Profil / Tentang Kami</label>
            <textarea id="profil_text" name="profil_text" class="form-input" rows="6">{{ old('profil_text', $settings['profil_text'] ?? '') }}</textarea>
            <div class="form-help">Penjelasan singkat tentang jurusan / sekolah.</div>
          </div>
        </div>

        <!-- Section Tampilan & Tema -->
        <div class="settings-section">
          <h3 class="section-title-small"><i class="fas fa-palette"></i> Tampilan & Tema Publik</h3>

          <div class="form-group">
            <label class="form-label" for="theme_primary_color">Warna Utama (Primary)</label>
            <div style="display:flex; align-items:center; gap:1rem">
                <input type="color" id="theme_primary_color" name="theme_primary_color" value="{{ old('theme_primary_color', $settings['theme_primary_color'] ?? '#0ea5e9') }}" style="width:60px; height:45px; border:none; border-radius:8px; cursor:pointer; background:none">
                <input type="text" value="{{ old('theme_primary_color', $settings['theme_primary_color'] ?? '#0ea5e9') }}" class="form-input" style="flex:1" readonly>
            </div>
            <div class="form-help">Digunakan untuk tombol, link, dan elemen aksen utama.</div>
          </div>

          <div class="form-group">
            <label class="form-label" for="theme_secondary_color">Warna Sekunder (Secondary)</label>
            <div style="display:flex; align-items:center; gap:1rem">
                <input type="color" id="theme_secondary_color" name="theme_secondary_color" value="{{ old('theme_secondary_color', $settings['theme_secondary_color'] ?? '#10b981') }}" style="width:60px; height:45px; border:none; border-radius:8px; cursor:pointer; background:none">
                <input type="text" value="{{ old('theme_secondary_color', $settings['theme_secondary_color'] ?? '#10b981') }}" class="form-input" style="flex:1" readonly>
            </div>
            <div class="form-help">Digunakan untuk elemen pendukung dan gradien.</div>
          </div>

          <div class="form-group">
            <label class="form-label" for="theme_border_radius">Gaya Sudut (Border Radius)</label>
            <select id="theme_border_radius" name="theme_border_radius" class="form-input">
                <option value="4px" {{ (old('theme_border_radius', $settings['theme_border_radius'] ?? '16px') == '4px') ? 'selected' : '' }}>Tajam (4px)</option>
                <option value="10px" {{ (old('theme_border_radius', $settings['theme_border_radius'] ?? '16px') == '10px') ? 'selected' : '' }}>Slight Smooth (10px)</option>
                <option value="16px" {{ (old('theme_border_radius', $settings['theme_border_radius'] ?? '16px') == '16px') ? 'selected' : '' }}>Standard Rounded (16px)</option>
                <option value="24px" {{ (old('theme_border_radius', $settings['theme_border_radius'] ?? '16px') == '24px') ? 'selected' : '' }}>Extra Smooth (24px)</option>
            </select>
            <div class="form-help">Mengatur kelengkungan sudut kartu dan tombol.</div>
          </div>
        </div>

        <!-- Section Ikon Teknologi & Klien -->
        <div class="settings-section">
          <h3 class="section-title-small"><i class="fas fa-network-wired"></i> Ikon Teknologi &amp; Mitra Klien</h3>

          <div class="form-group">
            <label class="form-label" for="tech_stacks">Daftar Ikon Teknologi (Tech Stack)</label>
            <input type="text" id="tech_stacks" name="tech_stacks" class="form-input" value="{{ old('tech_stacks', $settings['tech_stacks'] ?? '') }}">
            <div class="form-help">Pisahkan dengan koma. Contoh: <code>html5, css3-alt, js, php, laravel, database, git-alt, node-js</code> (Menggunakan class FontAwesome fab/fas).</div>
          </div>

          <div class="form-group">
            <label class="form-label" for="client_logos">Daftar Logo Klien (Client Ticker)</label>
            <input type="text" id="client_logos" name="client_logos" class="form-input" value="{{ old('client_logos', $settings['client_logos'] ?? '') }}">
            <div class="form-help">Pisahkan dengan koma. Contoh: <code>INDOMARET, PERTAMINA, KAI, PLN, BRI</code>.</div>
          </div>
        </div>

        <!-- Section Statistik Pencapaian -->
        <div class="settings-section">
          <h3 class="section-title-small"><i class="fas fa-chart-line"></i> Statistik Keunggulan (Pencapaian)</h3>
          
          <div style="display:grid; grid-template-columns: 1fr 2fr; gap:0.5rem; margin-bottom:1rem;">
            <div>
              <label class="form-label" for="stat_keunggulan_1_num">Stat 1 Angka</label>
              <input type="text" id="stat_keunggulan_1_num" name="stat_keunggulan_1_num" class="form-input" value="{{ old('stat_keunggulan_1_num', $settings['stat_keunggulan_1_num'] ?? '') }}">
            </div>
            <div>
              <label class="form-label" for="stat_keunggulan_1_lbl">Stat 1 Label</label>
              <input type="text" id="stat_keunggulan_1_lbl" name="stat_keunggulan_1_lbl" class="form-input" value="{{ old('stat_keunggulan_1_lbl', $settings['stat_keunggulan_1_lbl'] ?? '') }}">
            </div>
          </div>

          <div style="display:grid; grid-template-columns: 1fr 2fr; gap:0.5rem; margin-bottom:1rem;">
            <div>
              <label class="form-label" for="stat_keunggulan_2_num">Stat 2 Angka</label>
              <input type="text" id="stat_keunggulan_2_num" name="stat_keunggulan_2_num" class="form-input" value="{{ old('stat_keunggulan_2_num', $settings['stat_keunggulan_2_num'] ?? '') }}">
            </div>
            <div>
              <label class="form-label" for="stat_keunggulan_2_lbl">Stat 2 Label</label>
              <input type="text" id="stat_keunggulan_2_lbl" name="stat_keunggulan_2_lbl" class="form-input" value="{{ old('stat_keunggulan_2_lbl', $settings['stat_keunggulan_2_lbl'] ?? '') }}">
            </div>
          </div>

          <div style="display:grid; grid-template-columns: 1fr 2fr; gap:0.5rem;">
            <div>
              <label class="form-label" for="stat_keunggulan_3_num">Stat 3 Angka</label>
              <input type="text" id="stat_keunggulan_3_num" name="stat_keunggulan_3_num" class="form-input" value="{{ old('stat_keunggulan_3_num', $settings['stat_keunggulan_3_num'] ?? '') }}">
            </div>
            <div>
              <label class="form-label" for="stat_keunggulan_3_lbl">Stat 3 Label</label>
              <input type="text" id="stat_keunggulan_3_lbl" name="stat_keunggulan_3_lbl" class="form-input" value="{{ old('stat_keunggulan_3_lbl', $settings['stat_keunggulan_3_lbl'] ?? '') }}">
            </div>
          </div>
        </div>

        <!-- Section Tabel Perbandingan -->
        <div class="settings-section" style="grid-column: span 2;">
          <h3 class="section-title-small"><i class="fas fa-table"></i> Tabel Perbandingan Spesifikasi &amp; Fitur Halaman Depan</h3>
          <div class="form-group">
            <label class="form-label" for="comparison_rows">Baris Perbandingan (Satu baris per fitur)</label>
            <textarea id="comparison_rows" name="comparison_rows" class="form-input" rows="10" style="font-family:monospace; font-size:0.9rem;">{{ old('comparison_rows', $settings['comparison_rows'] ?? '') }}</textarea>
            <div class="form-help">
              Format: <code>Fitur | Kolom Personal | Kolom UKM | Kolom Business | Kolom Enterprise</code>.<br>
              Gunakan <code>check</code> untuk centang hijau, atau <code>times</code> untuk silang merah. Contoh:<br>
              <code>Lisensi Kepemilikan | Sekali Putus (Lifetime) | Sekali Putus (Lifetime) | Sekali Putus (Lifetime) | Sekali Putus (Lifetime)</code><br>
              <code>Jumlah Database User | 1 User | Unlimited Users | Unlimited Users | Unlimited Users</code><br>
              <code>Absensi &amp; Payroll Karyawan | times | times | check | check</code>
            </div>
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
