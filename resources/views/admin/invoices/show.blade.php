@extends('admin.layout')

@section('title', 'Detail Invoice: ' . $invoice->number)
@section('page_title', 'Detail Invoice Tagihan')
@section('page_subtitle', $invoice->number . ' – ' . ($invoice->title ?? 'Tagihan Layanan'))

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; flex-wrap:wrap; gap:1rem;">
  <div>
    <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary btn-sm">
      <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
  </div>
  <div style="display:flex; gap:0.5rem; align-items:center;">
    <a href="{{ route('admin.invoices.print', $invoice->id) }}" target="_blank" class="btn btn-primary btn-sm">
      <i class="fas fa-print"></i> Cetak / Simpan PDF
    </a>
    <a href="{{ route('admin.invoices.edit', $invoice->id) }}" class="btn btn-secondary btn-sm" style="background:rgba(245, 158, 11, 0.15); color:var(--warning);">
      <i class="fas fa-edit"></i> Edit
    </a>
    @if($invoice->status !== 'paid')
      <form action="{{ route('admin.invoices.status', $invoice->id) }}" method="POST" style="margin:0">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="paid">
        <button type="submit" class="btn btn-sm" style="background:var(--success); color:white;">
          <i class="fas fa-check-double"></i> Tandai LUNAS
        </button>
      </form>
    @else
      <form action="{{ route('admin.invoices.status', $invoice->id) }}" method="POST" style="margin:0">
        @csrf
        @method('PATCH')
        <input type="hidden" name="status" value="unpaid">
        <button type="submit" class="btn btn-sm" style="background:rgba(245, 158, 11, 0.15); color:var(--warning);" title="Kembalikan ke status belum lunas">
          <i class="fas fa-undo"></i> Tandai Belum Lunas
        </button>
      </form>
    @endif
  </div>
</div>

<div class="card" style="margin-bottom:1.5rem;">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
      <h2 class="card-title">{{ $invoice->number }}</h2>
      <div style="font-size:0.85rem; color:var(--text-secondary); margin-top:4px;">{{ $invoice->title ?? 'Invoice Tagihan Layanan' }}</div>
    </div>
    <span class="badge {{ $invoice->status_badge_class }}" style="font-size:0.95rem; padding:8px 16px;">
      {{ $invoice->status_label }}
    </span>
  </div>

  <div class="card-body">
    <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:1.5rem; margin-bottom:2rem; padding-bottom:1.5rem; border-bottom:1px solid var(--border);">
      <div>
        <div style="font-size:0.75rem; text-transform:uppercase; color:var(--text-secondary); font-weight:600; letter-spacing:0.5px;">Ditagihkan Kepada:</div>
        <div style="font-size:1.1rem; font-weight:700; color:var(--text-primary); margin-top:4px;">{{ $invoice->client_name }}</div>
        @if($invoice->client_company)
          <div style="font-weight:600; color:var(--primary);">{{ $invoice->client_company }}</div>
        @endif
        @if($invoice->client_address)
          <div style="font-size:0.85rem; color:var(--text-secondary); margin-top:4px; line-height:1.4;">{{ $invoice->client_address }}</div>
        @endif
        @if($invoice->client_phone || $invoice->client_email)
          <div style="font-size:0.82rem; color:var(--text-secondary); margin-top:4px;">
            {{ $invoice->client_phone }} {{ $invoice->client_phone && $invoice->client_email ? '•' : '' }} {{ $invoice->client_email }}
          </div>
        @endif
      </div>

      <div>
        <div style="font-size:0.75rem; text-transform:uppercase; color:var(--text-secondary); font-weight:600; letter-spacing:0.5px;">Detail Tagihan:</div>
        <table style="width:100%; margin-top:6px; font-size:0.88rem;">
          <tr>
            <td style="color:var(--text-secondary); padding:3px 0;">Tanggal Invoice:</td>
            <td style="font-weight:600; text-align:right;">{{ $invoice->date ? $invoice->date->format('d F Y') : '-' }}</td>
          </tr>
          <tr>
            <td style="color:var(--text-secondary); padding:3px 0;">Jatuh Tempo:</td>
            <td style="font-weight:600; text-align:right; color:{{ $invoice->status !== 'paid' && $invoice->due_date && $invoice->due_date->isPast() ? 'var(--danger)' : 'var(--text-primary)' }};">
              {{ $invoice->due_date ? $invoice->due_date->format('d F Y') : '-' }}
            </td>
          </tr>
          @if($invoice->reference)
          <tr>
            <td style="color:var(--text-secondary); padding:3px 0;">Ref. Penawaran:</td>
            <td style="font-weight:600; text-align:right;">
              <a href="{{ route('admin.quotations.show', $invoice->reference->id) }}" style="color:var(--primary); text-decoration:none;">
                {{ $invoice->reference->number }}
              </a>
            </td>
          </tr>
          @endif
          <tr>
            <td style="color:var(--text-secondary); padding:3px 0;">Penerbit / PIC:</td>
            <td style="font-weight:600; text-align:right;">{{ $invoice->signer_name ?? 'Yusuf Burhani' }}</td>
          </tr>
        </table>
      </div>
    </div>

    @if($invoice->notes)
      <div style="background:rgba(255,255,255,0.02); border-left:3px solid var(--primary); padding:1rem; border-radius:4px; margin-bottom:1.5rem; font-size:0.9rem; color:var(--text-body); line-height:1.5;">
        {{ $invoice->notes }}
      </div>
    @endif

    {{-- Tabel Item Tagihan --}}
    <h3 style="font-size:1rem; font-weight:600; margin-bottom:0.75rem;"><i class="fas fa-list-ul" style="color:var(--primary); margin-right:6px;"></i>Rincian Tagihan Layanan</h3>
    <div class="table-responsive" style="margin-bottom:1.5rem;">
      <table class="doc-items-table">
        <thead>
          <tr>
            <th width="40">#</th>
            <th>Deskripsi / Item Tagihan</th>
            <th width="100" style="text-align:center;">Qty</th>
            <th width="120">Satuan</th>
            <th width="180" style="text-align:right;">Harga Satuan</th>
            <th width="180" style="text-align:right;">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          @foreach($invoice->items as $idx => $item)
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

    {{-- Ringkasan Biaya & Info Rekening --}}
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1.5rem; margin-bottom:2rem; align-items:start;">
      <div>
        @if($invoice->payment_info)
          <div style="background:rgba(14, 165, 233, 0.05); border:1px solid rgba(14, 165, 233, 0.2); padding:1.25rem; border-radius:var(--radius);">
            <div style="font-size:0.82rem; font-weight:700; color:var(--primary); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:0.5rem;">
              <i class="fas fa-university" style="margin-right:6px;"></i>Instruksi Pembayaran &amp; Rekening Bank
            </div>
            <div style="font-size:0.85rem; color:var(--text-primary); white-space:pre-line; line-height:1.6; font-family:monospace;">
              {{ $invoice->payment_info }}
            </div>
          </div>
        @endif
      </div>

      <div class="doc-calc-box">
        <div class="doc-calc-row">
          <span style="color:var(--text-secondary);">Subtotal:</span>
          <span style="font-weight:600;">{{ $invoice->formatted_subtotal }}</span>
        </div>
        @if($invoice->discount_amount > 0)
          <div class="doc-calc-row" style="color:var(--danger);">
            <span>Diskon ({{ $invoice->discount_type === 'percent' ? (float)$invoice->discount_value . '%' : 'Potongan' }}):</span>
            <span>-{{ $invoice->formatted_discount }}</span>
          </div>
        @endif
        @if($invoice->tax_amount > 0)
          <div class="doc-calc-row" style="color:var(--warning);">
            <span>PPN ({{ (float)$invoice->tax_percent }}%):</span>
            <span>+{{ $invoice->formatted_tax }}</span>
          </div>
        @endif
        <div class="doc-calc-row grand-total">
          <span>Total Tagihan:</span>
          <span>{{ $invoice->formatted_total }}</span>
        </div>
        <div style="font-size:0.8rem; color:var(--text-secondary); font-style:italic; text-align:right; margin-top:4px;">
          Terbilang: <strong>{{ $invoice->terbilang }}</strong>
        </div>
      </div>
    </div>

    {{-- Syarat & Ketentuan --}}
    @if($invoice->terms)
      <div style="border-top:1px solid var(--border); padding-top:1.5rem;">
        <h4 style="font-size:0.9rem; font-weight:700; text-transform:uppercase; color:var(--text-secondary); letter-spacing:0.5px; margin-bottom:0.5rem;">
          <i class="fas fa-shield-alt" style="margin-right:6px;"></i>Syarat &amp; Ketentuan Tagihan
        </h4>
        <div style="font-size:0.85rem; color:var(--text-body); white-space:pre-line; line-height:1.6; background:rgba(255,255,255,0.015); padding:1rem; border-radius:var(--radius-sm); border:1px solid var(--border);">
          {{ $invoice->terms }}
        </div>
      </div>
    @endif
  </div>
</div>
@endsection
