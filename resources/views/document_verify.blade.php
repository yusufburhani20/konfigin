<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifikasi Dokumen Resmi – {{ $settings['site_name'] ?? 'Konfigin IT Solutions' }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
      color: #f8fafc;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 24px 16px;
      line-height: 1.5;
    }
    .verify-card {
      width: 100%;
      max-width: 560px;
      background: rgba(30, 41, 59, 0.85);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(148, 163, 184, 0.15);
      border-radius: 20px;
      padding: 32px 28px;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
      text-align: center;
    }
    .brand-header {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 24px;
    }
    .brand-icon {
      font-family: monospace;
      font-size: 26px;
      font-weight: 800;
      color: #0ea5e9;
      letter-spacing: -1px;
    }
    .brand-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 20px;
      font-weight: 800;
      color: #ffffff;
      letter-spacing: -0.5px;
    }
    .brand-title em {
      font-style: normal;
      color: #0ea5e9;
    }

    .badge-icon-box {
      width: 76px;
      height: 76px;
      border-radius: 50%;
      margin: 0 auto 16px auto;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 34px;
    }
    .badge-icon-box.success {
      background: rgba(16, 185, 129, 0.15);
      color: #10b981;
      border: 2px solid rgba(16, 185, 129, 0.4);
      box-shadow: 0 0 25px rgba(16, 185, 129, 0.25);
    }
    .badge-icon-box.danger {
      background: rgba(239, 68, 68, 0.15);
      color: #ef4444;
      border: 2px solid rgba(239, 68, 68, 0.4);
    }

    .verify-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 20px;
      font-weight: 800;
      color: #ffffff;
      margin-bottom: 6px;
    }
    .verify-subtitle {
      font-size: 13px;
      color: #94a3b8;
      margin-bottom: 24px;
      line-height: 1.5;
    }

    .info-list {
      background: rgba(15, 23, 42, 0.6);
      border: 1px solid rgba(148, 163, 184, 0.12);
      border-radius: 14px;
      padding: 18px 20px;
      text-align: left;
      margin-bottom: 24px;
    }
    .info-row {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 9px 0;
      border-bottom: 1px solid rgba(148, 163, 184, 0.08);
      font-size: 13px;
    }
    .info-row:last-child {
      border-bottom: none;
      padding-bottom: 0;
    }
    .info-row:first-child {
      padding-top: 0;
    }
    .info-label {
      color: #94a3b8;
      font-size: 12.5px;
      min-width: 120px;
    }
    .info-value {
      font-weight: 600;
      color: #f8fafc;
      text-align: right;
    }
    .info-value.highlight {
      color: #0ea5e9;
      font-family: monospace;
      font-size: 14px;
    }

    .badge-status {
      display: inline-block;
      padding: 3px 10px;
      border-radius: 9999px;
      font-size: 11.5px;
      font-weight: 700;
      text-transform: uppercase;
    }
    .badge-paid {
      background: rgba(16, 185, 129, 0.2);
      color: #34d399;
      border: 1px solid rgba(16, 185, 129, 0.4);
    }
    .badge-unpaid {
      background: rgba(245, 158, 11, 0.2);
      color: #fbbf24;
      border: 1px solid rgba(245, 158, 11, 0.4);
    }

    .btn-home {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: #0ea5e9;
      color: white;
      text-decoration: none;
      padding: 12px 24px;
      border-radius: 10px;
      font-weight: 600;
      font-size: 14px;
      transition: all 0.2s;
    }
    .btn-home:hover {
      background: #0284c7;
      transform: translateY(-2px);
    }
    .footer-note {
      margin-top: 20px;
      font-size: 11px;
      color: #64748b;
    }
  </style>
</head>
<body>

  <div class="verify-card">
    {{-- Brand Logo --}}
    <div class="brand-header">
      <div class="brand-icon">{ &bull; }</div>
      <div class="brand-title">konfig<em>in</em></div>
    </div>

    @if($document)
      <div class="badge-icon-box success">
        <i class="fas fa-circle-check"></i>
      </div>

      <h1 class="verify-title">DOKUMEN TERVERIFIKASI RESMI</h1>
      <p class="verify-subtitle">
        Sistem mengonfirmasi bahwa dokumen ini adalah dokumen sah yang diterbitkan resmi oleh <strong>{{ $settings['site_name'] ?? 'Konfigin IT Solutions' }}</strong>.
      </p>

      <div class="info-list">
        <div class="info-row">
          <span class="info-label">Nomor Dokumen</span>
          <span class="info-value highlight">{{ $document->number }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Jenis Dokumen</span>
          <span class="info-value">{{ $document->type === 'invoice' ? 'Invoice Tagihan Resmi' : 'Surat Penawaran Harga (Quotation)' }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Perihal / Proyek</span>
          <span class="info-value">{{ $document->title ?? '-' }}</span>
        </div>
        <div class="info-row">
          <span class="info-label">Diterbitkan Untuk</span>
          <span class="info-value">
            {{ $document->client_name }}
            @if($document->client_company)
              <br><small style="color:#94a3b8; font-weight:normal;">{{ $document->client_company }}</small>
            @endif
          </span>
        </div>
        <div class="info-row">
          <span class="info-label">Tanggal Terbit</span>
          <span class="info-value">{{ $document->date ? $document->date->format('d F Y') : '-' }}</span>
        </div>
        @if($document->due_date)
        <div class="info-row">
          <span class="info-label">{{ $document->type === 'invoice' ? 'Jatuh Tempo' : 'Berlaku Hingga' }}</span>
          <span class="info-value">{{ $document->due_date->format('d F Y') }}</span>
        </div>
        @endif
        <div class="info-row">
          <span class="info-label">Total Nilai</span>
          <span class="info-value" style="font-size:15px; color:#38bdf8;">{{ $document->formatted_total }}</span>
        </div>
        @if($document->type === 'invoice')
        <div class="info-row">
          <span class="info-label">Status Tagihan</span>
          <span class="info-value">
            @if($document->status === 'paid')
              <span class="badge-status badge-paid"><i class="fas fa-check-circle"></i> LUNAS (PAID)</span>
            @else
              <span class="badge-status badge-unpaid"><i class="fas fa-clock"></i> BELUM LUNAS</span>
            @endif
          </span>
        </div>
        @endif
        <div class="info-row">
          <span class="info-label">Penanggung Jawab</span>
          <span class="info-value">{{ $document->signer_name ?? 'Yusuf Burhani' }} ({{ $document->signer_title ?? 'Founder Konfigin IT Solutions' }})</span>
        </div>
      </div>
    @else
      <div class="badge-icon-box danger">
        <i class="fas fa-times-circle"></i>
      </div>

      <h1 class="verify-title" style="color:#ef4444;">DOKUMEN TIDAK DITEMUKAN</h1>
      <p class="verify-subtitle">
        Nomor dokumen <strong>{{ $number }}</strong> tidak terdaftar atau tidak ditemukan dalam database resmi kami. Harap pastikan kembali keaslian dokumen fisik/digital yang Anda miliki.
      </p>
    @endif

    <div>
      <a href="{{ url('/') }}" class="btn-home">
        <i class="fas fa-external-link-alt"></i> Kunjungi Website Resmi Konfigin
      </a>
    </div>

    <div class="footer-note">
      © {{ date('Y') }} {{ $settings['site_name'] ?? 'Konfigin IT Solutions' }}. Sistem Verifikasi &amp; Tanda Tangan Digital.
    </div>
  </div>

</body>
</html>
