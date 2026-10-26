@extends('admin.layout')

@section('title', 'Detail Surat Penawaran: ' . $quotation->number)
@section('page_title', 'Detail Surat Penawaran')
@section('page_subtitle', $quotation->number . ' – ' . ($quotation->title ?? 'Solusi Teknologi Informasi'))

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
  <div>
    <a href="{{ route('admin.quotations.index') }}" class="btn btn-secondary btn-sm">
      <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
  </div>
  <div style="display:flex; gap:0.5rem;">
    <a href="{{ route('admin.quotations.print', $quotation->id) }}" target="_blank" class="btn btn-primary btn-sm">
      <i class="fas fa-print"></i> Cetak / Simpan PDF
    </a>
    <a href="{{ route('admin.quotations.edit', $quotation->id) }}" class="btn btn-secondary btn-sm" style="background:rgba(245, 158, 11, 0.15); color:var(--warning);">
      <i class="fas fa-edit"></i> Edit
    </a>
    @if($quotation->status !== 'converted')
      <form action="{{ route('admin.quotations.convert', $quotation->id) }}" method="POST" style="margin:0" onsubmit="return confirm('Konversi surat penawaran ini menjadi Invoice resmi?')">
        @csrf
        <button type="submit" class="btn btn-sm" style="background:var(--success); color:white;">
          <i class="fas fa-exchange-alt"></i> Konversi ke Invoice
        </button>
      </form>
    @else
      @if($quotation->invoices->count() > 0)
        @foreach($quotation->invoices as $inv)
          <a href="{{ route('admin.invoices.show', $inv->id) }}" class="btn btn-sm" style="background:rgba(16, 185, 129, 0.15); color:var(--success);">
            <i class="fas fa-receipt"></i> Buka Invoice {{ $inv->number }}
          </a>
        @endforeach
      @endif
    @endif
  </div>
</div>

<div class="card" style="margin-bottom:1.5rem;">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
      <h2 class="card-title">{{ $quotation->number }}</h2>
      <div style="font-size:0.85rem; color:var(--text-secondary); margin-top:4px;">{{ $quotation->title ?? 'Penawaran Layanan IT' }}</div>
    </div>
    <span class="badge {{ $quotation->status_badge_class }}" style="font-size:0.9rem; padding:6px 14px;">
      {{ $quotation->status_label }}
    </span>
  </div>

  <div class="card-body">
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:1.5rem; margin-bottom:2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--border);">
      <div>
        <div style="font-size:0.75rem; text-transform:uppercase; color:var(--text-secondary); font-weight:600; letter-spacing:0.5px;">Diterbitkan Untuk:</div>
        <div style="font-size:1.1rem; font-weight:700; color:var(--text-primary); margin-top:4px;">{{ $quotation->client_name }}</div>
        @if($quotation->client_company)
          <div style="font-weight:600; color:var(--primary);">{{ $quotation->client_company }}</div>
        @endif
        @if($quotation->client_address)
          <div style="font-size:0.85rem; color:var(--text-secondary); margin-top:4px; line-height:1.4;">{{ $quotation->client_address }}</div>
        @endif
        @if($quotation->client_phone || $quotation->client_email)
          <div style="font-size:0.82rem; color:var(--text-secondary); margin-top:4px;">
            {{ $quotation->client_phone }} {{ $quotation->client_phone && $quotation->client_email ? '•' : '' }} {{ $quotation->client_email }}
          </div>
        @endif
      </div>

      <div>
        <div style="font-size:0.75rem; text-transform:uppercase; color:var(--text-secondary); font-weight:600; letter-spacing:0.5px;">Informasi Tanggal:</div>
        <table style="width:100%; margin-top:6px; font-size:0.88rem;">
          <tr>
            <td style="color:var(--text-secondary); padding:3px 0;">Tanggal Terbit:</td>
            <td style="font-weight:600; text-align:right;">{{ $quotation->date ? $quotation->date->format('d F Y') : '-' }}</td>
          </tr>
          <tr>
            <td style="color:var(--text-secondary); padding:3px 0;">Berlaku Hingga:</td>
            <td style="font-weight:600; text-align:right; color:var(--warning);">{{ $quotation->due_date ? $quotation->due_date->format('d F Y') : '-' }}</td>
          </tr>
          <tr>
            <td style="color:var(--text-secondary); padding:3px 0;">Penanggung Jawab:</td>
            <td style="font-weight:600; text-align:right;">{{ $quotation->signer_name ?? 'Yusuf Burhani' }}</td>
          </tr>
        </table>
      </div>
    </div>

    @if($quotation->notes)
      <div style="background:rgba(255,255,255,0.02); border-left:3px solid var(--primary); padding:1rem; border-radius:4px; margin-bottom:1.5rem; font-size:0.9rem; color:var(--text-body); line-height:1.5;">
        {{ $quotation->notes }}
      </div>
    @endif

    {{-- Tabel Item Layanan --}}
    <h3 style="font-size:1rem; font-weight:600; margin-bottom:0.75rem;"><i class="fas fa-list-ul" style="color:var(--primary); margin-right:6px;"></i>Daftar Layanan &amp; Penawaran Harga</h3>
    <div class="table-responsive" style="margin-bottom:1.5rem;">
      <table class="doc-items-table">
        <thead>
          <tr>
            <th width="40">#</th>
            <th>Uraian / Modul Layanan</th>
            <th width="100" style="text-align:center;">Qty</th>
            <th width="120">Satuan</th>
            <th width="180" style="text-align:right;">Harga Satuan</th>
            <th width="180" style="text-align:right;">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @foreach($quotation->items as $idx => $item)
          <tr>
            <td style="color:var(--text-secondary);">{{ $loop->iteration }}</td>
            <td>
              <div style="font-weight:600; color:var(--text-primary);">{{ $item->item_name }}</div>
              @if($item->description)
                <div style="font-size:0.83rem; color:var(--text-secondary); margin-top:4px; line-height:1.4; white-space:pre-line;">{{ $item->description }}</div>
              @endif
            </td>
            <td style="text-align:center; font-weight:500;">{{ (float)$item->quantity }}</td>
            <td style="color:var(--text-secondary);">{{ $item->unit }}</td>
            <td style="text-align:right;">{{ $item->formatted_price }}</td>
            <td style="text-align:right; font-weight:600; color:var(--text-primary);">{{ $item->formatted_amount }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Ringkasan Biaya --}}
    <div style="display:flex; justify-content:flex-end; margin-bottom:2rem;">
      <div style="width:100%; max-width:400px;" class="doc-calc-box">
        <div class="doc-calc-row">
          <span style="color:var(--text-secondary);">Subtotal Biaya:</span>
          <span style="font-weight:600;">{{ $quotation->formatted_subtotal }}</span>
        </div>
        @if($quotation->discount_amount > 0)
          <div class="doc-calc-row" style="color:var(--danger);">
            <span>Diskon ({{ $quotation->discount_type === 'percent' ? (float)$quotation->discount_value . '%' : 'Potongan' }}):</span>
            <span>-{{ $quotation->formatted_discount }}</span>
          </div>
        @endif
        @if($quotation->tax_amount > 0)
          <div class="doc-calc-row" style="color:var(--warning);">
            <span>PPN ({{ (float)$quotation->tax_percent }}%):</span>
            <span>+{{ $quotation->formatted_tax }}</span>
          </div>
        @endif
        <div class="doc-calc-row grand-total">
          <span>Total Penawaran:</span>
          <span>{{ $quotation->formatted_total }}</span>
        </div>
        <div style="font-size:0.8rem; color:var(--text-secondary); font-style:italic; text-align:right; margin-top:4px;">
          Terbilang: <strong>{{ $quotation->terbilang }}</strong>
        </div>
      </div>
    </div>

    {{-- Syarat & Ketentuan --}}
    @if($quotation->terms)
      <div style="border-top:1px solid var(--border); padding-top:1.5rem;">
        <h4 style="font-size:0.9rem; font-weight:700; text-transform:uppercase; color:var(--text-secondary); letter-spacing:0.5px; margin-bottom:0.5rem;">
          <i class="fas fa-shield-alt" style="margin-right:6px;"></i>Syarat &amp; Ketentuan
        </h4>
        <div style="font-size:0.85rem; color:var(--text-body); white-space:pre-line; line-height:1.6; background:rgba(255,255,255,0.015); padding:1rem; border-radius:var(--radius-sm); border:1px solid var(--border);">
          {{ $quotation->terms }}
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
