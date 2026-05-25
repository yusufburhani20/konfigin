@extends('admin.layout')

@section('title', 'Informasi Kontak')
@section('page_title', 'Informasi Kontak')
@section('page_subtitle', 'Atur nomor WhatsApp, email, dan alamat')

@section('content')
<div class="card">
  <div class="card-header">
    <h2 class="card-title">Edit Kontak & Sosial Media</h2>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.kontak.update') }}">
      @csrf
      @method('PUT')
      
      <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap:1.5rem">
        <div class="form-group">
          <label class="form-label" for="whatsapp">
            <i class="fab fa-whatsapp" style="color:#25d366"></i> Nomor WhatsApp
          </label>
          <input type="text" id="whatsapp" name="whatsapp" class="form-input" value="{{ old('whatsapp', $kontak->whatsapp ?? '') }}" placeholder="08xx-xxxx-xxxx">
          <div class="form-help">Sistem otomatis mengubah format ke link <code>wa.me/62...</code> di tombol.</div>
        </div>

        <div class="form-group">
          <label class="form-label" for="email">
            <i class="fas fa-envelope" style="color:var(--primary)"></i> Email Resmi
          </label>
          <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $kontak->email ?? '') }}" placeholder="email@sekolah.sch.id">
        </div>

        <div class="form-group">
          <label class="form-label" for="website">
            <i class="fas fa-globe" style="color:var(--secondary)"></i> Link Website Utama
          </label>
          <input type="text" id="website" name="website" class="form-input" value="{{ old('website', $kontak->website ?? '') }}" placeholder="https://">
          <div class="form-help">Link tombol "Kunjungi Website Resmi" di bagian bawah.</div>
        </div>
      </div>

      <div class="spacer-py"></div>

      <div class="form-group">
        <label class="form-label" for="alamat">
          <i class="fas fa-map-marker-alt" style="color:var(--accent)"></i> Alamat Lengkap
        </label>
        <textarea id="alamat" name="alamat" class="form-input" rows="3" placeholder="Jl. Raya ...">{{ old('alamat', $kontak->alamat ?? '') }}</textarea>
      </div>

      <div style="margin-top:2rem">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-save"></i> Simpan Perubahan Kontak
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
