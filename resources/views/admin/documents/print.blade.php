<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $document->number }} - {{ $document->type === 'quotation' ? 'Surat Penawaran' : 'Invoice' }} | Konfigin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    *, *::before, *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      color: #1e293b;
      background: #f1f5f9;
      font-size: 13px;
      line-height: 1.5;
      padding: 20px;
    }

    /* Action bar on screen */
    .action-bar {
      max-width: 800px;
      margin: 0 auto 15px auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #0f172a;
      color: white;
      padding: 12px 20px;
      border-radius: 8px;
      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
    }
    .action-bar .btn {
      padding: 8px 16px;
      border-radius: 6px;
      font-weight: 600;
      font-size: 13px;
      cursor: pointer;
      border: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      text-decoration: none;
    }
    .btn-print { background: #0ea5e9; color: white; }
    .btn-print:hover { background: #0284c7; }
    .btn-close { background: rgba(255,255,255,0.15); color: white; }
    .btn-close:hover { background: rgba(255,255,255,0.25); }

    /* Paper Page for Print */
    .print-page {
      max-width: 800px;
      margin: 0 auto;
      background: #ffffff;
      padding: 40px 45px;
      border-radius: 6px;
      box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
      position: relative;
    }

    /* Paid Watermark */
    .watermark-paid {
      position: absolute;
      top: 35%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(-25deg);
      font-size: 75px;
      font-weight: 900;
      color: rgba(16, 185, 129, 0.12);
      border: 8px solid rgba(16, 185, 129, 0.18);
      padding: 10px 40px;
      border-radius: 16px;
      pointer-events: none;
      text-transform: uppercase;
      letter-spacing: 5px;
      z-index: 1;
    }

    /* Header & Kop */
    .kop-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      border-bottom: 2px solid #0f172a;
      padding-bottom: 18px;
      margin-bottom: 22px;
    }
    .company-logo {
      max-height: 55px;
      margin-bottom: 6px;
      display: block;
    }
    .company-brand {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 20px;
      font-weight: 800;
      color: #0f172a;
      letter-spacing: -0.5px;
    }
    .company-tagline {
      font-size: 11px;
      color: #64748b;
      margin-bottom: 6px;
      font-weight: 500;
    }
    .company-meta {
      font-size: 11px;
      color: #475569;
      line-height: 1.45;
    }

    .doc-headline {
      text-align: right;
    }
    .doc-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 22px;
      font-weight: 800;
      color: #0ea5e9;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 4px;
    }
    .doc-number {
      font-size: 13px;
      font-weight: 700;
      color: #0f172a;
      font-family: monospace;
    }
    .doc-meta-table {
      margin-top: 8px;
      margin-left: auto;
      font-size: 11.5px;
    }
    .doc-meta-table td {
      padding: 2px 4px;
    }
    .doc-meta-table .label {
      color: #64748b;
      text-align: right;
    }
    .doc-meta-table .val {
      font-weight: 600;
      color: #0f172a;
      text-align: right;
    }

    /* Client Info */
    .client-section {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      padding: 14px 18px;
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 20px;
    }
    .client-left {
      flex: 1;
    }
    .section-label {
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      color: #0ea5e9;
      margin-bottom: 4px;
    }
    .client-name {
      font-size: 14px;
      font-weight: 700;
      color: #0f172a;
    }
    .client-company {
      font-size: 12.5px;
      font-weight: 600;
      color: #334155;
      margin-bottom: 3px;
    }
    .client-details {
      font-size: 11.5px;
      color: #64748b;
      line-height: 1.4;
    }
    .project-title {
      font-size: 12.5px;
      font-weight: 600;
      color: #0f172a;
      margin-top: 4px;
    }

    /* Table Items */
    .items-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 18px;
    }
    .items-table th {
      background: #0f172a;
      color: #ffffff;
      padding: 8px 12px;
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      text-align: left;
    }
    .items-table td {
      padding: 10px 12px;
      border-bottom: 1px solid #e2e8f0;
      vertical-align: top;
      font-size: 12px;
    }
    .items-table tr:nth-child(even) td {
      background: #f8fafc;
    }
    .item-title {
      font-weight: 600;
      color: #0f172a;
    }
    .item-desc {
      font-size: 11px;
      color: #64748b;
      margin-top: 3px;
      white-space: pre-line;
      line-height: 1.4;
    }

    /* Calculation Section */
    .calc-container {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 20px;
      margin-bottom: 22px;
    }
    .calc-left {
      flex: 1;
    }
    .terbilang-box {
      background: #f8fafc;
      border-left: 3px solid #0ea5e9;
      padding: 10px 14px;
      font-size: 11.5px;
      color: #334155;
      margin-bottom: 12px;
      line-height: 1.45;
    }
    .terbilang-box strong {
      color: #0f172a;
    }

    .calc-table {
      width: 290px;
      border-collapse: collapse;
      font-size: 12px;
    }
    .calc-table td {
      padding: 4px 6px;
    }
    .calc-table .label {
      color: #64748b;
    }
    .calc-table .val {
      text-align: right;
      font-weight: 600;
      color: #0f172a;
    }
    .calc-table tr.total-row td {
      border-top: 2px solid #0f172a;
      padding-top: 6px;
      margin-top: 4px;
      font-size: 14px;
      font-weight: 800;
      color: #0ea5e9;
    }

    /* Notes & Terms Box */
    .box-info {
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      padding: 10px 14px;
      font-size: 11px;
      color: #334155;
      margin-bottom: 12px;
      line-height: 1.5;
    }
    .box-info-title {
      font-size: 10.5px;
      font-weight: 700;
      text-transform: uppercase;
      color: #0f172a;
      margin-bottom: 4px;
      display: flex;
      align-items: center;
      gap: 5px;
    }

    /* Signature Section */
    .sign-section {
      display: flex;
      justify-content: space-between;
      margin-top: 30px;
      padding-top: 15px;
    }
    .sign-box {
      width: 220px;
      text-align: center;
      font-size: 11.5px;
    }
    .sign-title {
      font-weight: 600;
      color: #475569;
      margin-bottom: 65px;
    }
    .sign-name {
      font-weight: 700;
      color: #0f172a;
      border-bottom: 1px solid #0f172a;
      padding-bottom: 3px;
      display: inline-block;
      min-width: 170px;
    }
    .sign-position {
      font-size: 10.5px;
      color: #64748b;
      margin-top: 3px;
    }

    /* Footer Note */
    .print-footer {
      border-top: 1px solid #e2e8f0;
      margin-top: 25px;
      padding-top: 10px;
      font-size: 10px;
      color: #94a3b8;
      text-align: center;
    }

    /* PRINT MEDIA QUERY */
    @media print {
      body {
        background: #ffffff;
        padding: 0;
        margin: 0;
        font-size: 12px;
      }
      .action-bar {
        display: none !important;
      }
      .print-page {
        box-shadow: none;
        padding: 15mm 15mm;
        max-width: 100%;
        margin: 0;
        border-radius: 0;
      }
      @page {
        size: A4 portrait;
        margin: 0;
      }
      * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
      }
    }
  </style>
</head>
<body>

  {{-- Action Bar (Hanya tampil di layar) --}}
  <div class="action-bar">
    <div style="font-weight:600; font-size:14px;">
      <i class="fas fa-file-alt" style="color:#0ea5e9; margin-right:6px;"></i>
      Pratinjau Dokumen: {{ $document->number }}
    </div>
    <div style="display:flex; gap:10px;">
      <button onclick="window.print()" class="btn btn-print">
        <i class="fas fa-print"></i> Cetak / Simpan PDF
      </button>
      <button onclick="window.close()" class="btn btn-close">
        <i class="fas fa-times"></i> Tutup
      </button>
    </div>
  </div>

  {{-- Print Page Paper --}}
  <div class="print-page">
    
    @if($document->type === 'invoice' && $document->status === 'paid')
      <div class="watermark-paid">LUNAS</div>
    @endif

    {{-- KOP SURAT --}}
    <div class="kop-header">
      <div class="company-info">
        @if(!empty($settings['site_logo']))
          <img src="{{ asset($settings['site_logo']) }}" alt="Logo" class="company-logo">
        @else
          <div class="company-brand">{{ $settings['site_name'] ?? 'KONFIGIN IT SOLUTIONS' }}</div>
        @endif
        <div class="company-tagline">{{ $settings['site_tagline'] ?? 'IT Infrastructure & Software Development Solutions' }}</div>
        <div class="company-meta">
          @if(!empty($kontak->alamat))
            <div>{{ $kontak->alamat }}</div>
          @endif
          <div>
            @if(!empty($kontak->whatsapp)) WhatsApp: {{ $kontak->whatsapp }} @endif
            @if(!empty($kontak->email)) • Email: {{ $kontak->email }} @endif
          </div>
          <div>Website: {{ $kontak->website ?? 'https://konfigin.my.id' }}</div>
        </div>
      </div>

      <div class="doc-headline">
        <div class="doc-title">
          {{ $document->type === 'quotation' ? 'Surat Penawaran' : 'Invoice Tagihan' }}
        </div>
        <div class="doc-number">{{ $document->number }}</div>

        <table class="doc-meta-table">
          <tr>
            <td class="label">Tanggal:</td>
            <td class="val">{{ $document->date ? $document->date->format('d/m/Y') : '-' }}</td>
          </tr>
          <tr>
            <td class="label">{{ $document->type === 'quotation' ? 'Berlaku s/d:' : 'Jatuh Tempo:' }}</td>
            <td class="val">{{ $document->due_date ? $document->due_date->format('d/m/Y') : '-' }}</td>
          </tr>
          @if($document->reference)
          <tr>
            <td class="label">Ref. Penawaran:</td>
            <td class="val">{{ $document->reference->number }}</td>
          </tr>
          @endif
          @if($document->type === 'invoice')
          <tr>
            <td class="label">Status:</td>
            <td class="val" style="color:{{ $document->status === 'paid' ? '#10b981' : '#f59e0b' }};">
              {{ $document->status_label }}
            </td>
          </tr>
          @endif
        </table>
      </div>
    </div>

    {{-- Data Penerima (Klien) --}}
    <div class="client-section">
      <div class="client-left">
        <div class="section-label">
          {{ $document->type === 'quotation' ? 'Penawaran Ditujukan Kepada:' : 'Ditagihkan Kepada:' }}
        </div>
        <div class="client-name">{{ $document->client_name }}</div>
        @if($document->client_company)
          <div class="client-company">{{ $document->client_company }}</div>
        @endif
        @if($document->client_address)
          <div class="client-details">{{ $document->client_address }}</div>
        @endif
        @if($document->client_phone || $document->client_email)
          <div class="client-details">
            {{ $document->client_phone }} {{ $document->client_phone && $document->client_email ? '•' : '' }} {{ $document->client_email }}
          </div>
        @endif
      </div>
      <div style="min-width:200px; text-align:right;">
        <div class="section-label">Perihal / Proyek:</div>
        <div class="project-title">{{ $document->title ?? '-' }}</div>
      </div>
    </div>

    @if($document->notes)
      <div style="font-size:11.5px; color:#475569; margin-bottom:14px; font-style:italic;">
        "{{ $document->notes }}"
      </div>
    @endif

    {{-- Tabel Rincian Item --}}
    <table class="items-table">
      <thead>
        <tr>
          <th width="30" style="text-align:center;">No</th>
          <th>Deskripsi Layanan / Item</th>
          <th width="60" style="text-align:center;">Qty</th>
          <th width="75">Satuan</th>
          <th width="125" style="text-align:right;">Harga Satuan</th>
          <th width="135" style="text-align:right;">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach($document->items as $item)
        <tr>
          <td style="text-align:center; color:#64748b;">{{ $loop->iteration }}</td>
          <td>
            <div class="item-title">{{ $item->item_name }}</div>
            @if($item->description)
              <div class="item-desc">{{ $item->description }}</div>
            @endif
          </td>
          <td style="text-align:center;">{{ (float)$item->quantity }}</td>
          <td>{{ $item->unit }}</td>
          <td style="text-align:right;">{{ $item->formatted_price }}</td>
          <td style="text-align:right; font-weight:600;">{{ $item->formatted_amount }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    {{-- Kalkulasi & Terbilang --}}
    <div class="calc-container">
      <div class="calc-left">
        <div class="terbilang-box">
          Terbilang: <strong>{{ $document->terbilang }}</strong>
        </div>

        @if($document->type === 'invoice' && $document->payment_info)
          <div class="box-info">
            <div class="box-info-title"><i class="fas fa-university"></i> Rekening Pembayaran Resmi:</div>
            <div style="font-family:monospace; font-size:11px; white-space:pre-line; color:#0f172a;">{{ $document->payment_info }}</div>
          </div>
        @endif
      </div>

      <table class="calc-table">
        <tr>
          <td class="label">Subtotal:</td>
          <td class="val">{{ $document->formatted_subtotal }}</td>
        </tr>
        @if($document->discount_amount > 0)
        <tr>
          <td class="label">Diskon ({{ $document->discount_type === 'percent' ? (float)$document->discount_value . '%' : 'Potongan' }}):</td>
          <td class="val" style="color:#ef4444;">-{{ $document->formatted_discount }}</td>
        </tr>
        @endif
        @if($document->tax_amount > 0)
        <tr>
          <td class="label">PPN ({{ (float)$document->tax_percent }}%):</td>
          <td class="val">+{{ $document->formatted_tax }}</td>
        </tr>
        @endif
        <tr class="total-row">
          <td>Total Akhir:</td>
          <td class="val">{{ $document->formatted_total }}</td>
        </tr>
      </table>
    </div>

    {{-- Syarat & Ketentuan --}}
    @if($document->terms)
      <div class="box-info" style="margin-top:10px;">
        <div class="box-info-title"><i class="fas fa-info-circle"></i> Syarat &amp; Ketentuan:</div>
        <div style="white-space:pre-line;">{{ $document->terms }}</div>
      </div>
    @endif

    {{-- Tanda Tangan --}}
    <div class="sign-section">
      <div class="sign-box">
        <div class="sign-title">
          {{ $document->type === 'quotation' ? 'Disetujui Oleh (Klien),' : 'Penerima Tagihan,' }}
        </div>
        <div class="sign-name">{{ $document->client_name }}</div>
        <div class="sign-position">{{ $document->client_company ?? 'Klien / Mitra' }}</div>
      </div>

      <div class="sign-box">
        <div class="sign-title">
          Hormat Kami,<br>
          <strong>{{ $settings['site_name'] ?? 'Konfigin IT Solutions' }}</strong>
        </div>
        <div class="sign-name">{{ $document->signer_name ?? 'Yusuf Burhani' }}</div>
        <div class="sign-position">{{ $document->signer_title ?? 'Lead IT Consultant' }}</div>
      </div>
    </div>

    {{-- Footer --}}
    <div class="print-footer">
      Dokumen ini sah dan diterbitkan secara resmi oleh sistem <strong>{{ $settings['site_name'] ?? 'Konfigin IT Solutions' }}</strong> • {{ $document->number }}
    </div>

  </div>

</body>
</html>
