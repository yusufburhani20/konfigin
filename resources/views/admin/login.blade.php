<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login – Admin Konfigin IT Solutions</title>
  <meta name="robots" content="noindex, nofollow" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}" />
</head>
<body class="login-page">
  <div class="login-container">
    <div class="login-card">
      <div class="login-logo" style="display:flex; justify-content:center; align-items:center; margin-bottom:1.5rem">
        <img src="{{ asset('assets/img/konfigin-logo.png') }}" alt="Logo" style="max-height: 52px; object-fit: contain;">
      </div>
      <h1 class="login-title" style="font-family:'Plus Jakarta Sans', sans-serif; font-size:1.5rem; font-weight:800; text-align:center; color:var(--text-primary);">Dashboard Admin</h1>
      <p class="login-subtitle" style="text-align:center; color:var(--text-secondary); margin-bottom:2rem; font-size:0.9rem;">Konfigin IT Solutions</p>

      @if($errors->any())
      <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        {{ $errors->first() }}
      </div>
      @endif

      @if(session('error'))
      <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
      </div>
      @endif

      <form method="POST" action="{{ route('admin.login.post') }}">
        @csrf
        <div class="form-group">
          <label for="username" class="form-label">
            <i class="fas fa-user"></i> Username
          </label>
          <input type="text"
                 id="username"
                 name="username"
                 class="form-input"
                 value="{{ old('username') }}"
                 placeholder="Masukkan username"
                 required
                 autofocus />
        </div>
        <div class="form-group">
          <label for="password" class="form-label">
            <i class="fas fa-lock"></i> Password
          </label>
          <input type="password"
                 id="password"
                 name="password"
                 class="form-input"
                 placeholder="Masukkan password"
                 required />
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; margin-top:1rem" id="btn-login">
          <i class="fas fa-sign-in-alt"></i> Masuk
        </button>
      </form>

      <div style="text-align:center; margin-top:1.5rem">
        <a href="{{ route('home') }}" style="color:var(--primary); font-size:0.875rem; text-decoration:none;">
          <i class="fas fa-arrow-left"></i> Kembali ke Website
        </a>
      </div>
    </div>
  </div>
</body>
</html>
