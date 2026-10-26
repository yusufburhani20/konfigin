@extends('admin.layout')

@section('title', 'Manajemen Invoice (Tagihan)')
@section('page_title', 'Invoice & Tagihan Klien')
@section('page_subtitle', 'Kelola penerbitan tagihan, status pembayaran, dan rekapitulasi invoice')

@section('content')
{{-- Stat Pills Ringkasan --}}
<div class="stat-card-row">
  <div class="stat-pill">
    <div class="stat-pill-icon green"><i class="fas fa-check-circle"></i></div>
    <div>
      <div class="stat-pill-val">Rp {{ number_format($totalPaid, 0, ',', '.') }}</div>
      <div class="stat-pill-label">Total Pembayaran Diterima (Lunas)</div>
    </div>
  </div>
  <div class="stat-pill">
    <div class="stat-pill-icon orange"><i class="fas fa-clock"></i></div>
    <div>
      <div class="stat-pill-val">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</div>
      <div class="stat-pill-label">Piutang Belum Lunas ({{ $countUnpaid }} Invoice)</div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
    <div>
      <h2 class="card-title"><i class="fas fa-file-invoice-dollar" style="color:var(--primary); margin-right:8px;"></i>Daftar Invoice</h2>
    </div>
    <div style="display:flex; gap:0.75rem; align-items:center;">
      <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Terbitkan Invoice Baru
      </a>
    </div>
  </div>

  <div class="card-body" style="padding-bottom: 0;">
    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('admin.invoices.index') }}" style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-bottom:1.5rem;">
      <div style="flex:1; min-width:240px;">
        <input type="text" name="search" class="form-input" placeholder="Cari nomor invoice, perihal, nama klien..." value="{{ request('search') }}">
      </div>
      <div style="min-width:160px;">
        <select name="status" class="form-input" onchange="this.form.submit()">
          <option value="">Semua Status</option>
          <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Belum Lunas</option>
          <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Lunas</option>
          <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
          <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
      </div>
      <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i> Cari</button>
      @if(request()->hasAny(['search', 'status']))
        <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary btn-sm" title="Reset Filter"><i class="fas fa-times"></i> Reset</a>
      @endif
    </form>
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>No. Invoice</th>
          <th>Tanggal &amp; Jatuh Tempo</th>
          <th>Klien / Perusahaan</th>
          <th>Perihal / Layanan</th>
          <th style="text-align:right;">Nominal Tagihan</th>
          <th style="text-align:center;">Status</th>
          <th width="190" style="text-align:center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($invoices as $item)
        <tr>
          <td>
            <a href="{{ route('admin.invoices.show', $item->id) }}" style="font-weight:700; color:var(--primary); text-decoration:none;">
              {{ $item->number }}
            </a>
            @if($item->reference)
              <div style="font-size:0.72rem; color:var(--text-secondary); margin-top:2px;">
                <i class="fas fa-link"></i> Ref: {{ $item->reference->number }}
              </div>
            @endif
          </td>
          <td>
            <div style="font-weight:500;">{{ $item->date ? $item->date->format('d M Y') : '-' }}</div>
            <div style="font-size:0.75rem; color:{{ $item->status !== 'paid' && $item->due_date && $item->due_date->isPast() ? 'var(--danger)' : 'var(--text-secondary)' }};">
              Jatuh Tempo: {{ $item->due_date ? $item->due_date->format('d M Y') : '-' }}
            </div>
          </td>
          <td>
            <div style="font-weight:600;">{{ $item->client_name }}</div>
            @if(!empty($item->client_company))
              <div style="font-size:0.78rem; color:var(--text-secondary);">{{ $item->client_company }}</div>
            @endif
          </td>
          <td>
            <div style="max-width:220px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="{{ $item->title ?? '-' }}">
              {{ $item->title ?? '-' }}
            </div>
            <div style="font-size:0.75rem; color:var(--text-secondary);">
              {{ $item->items->count() }} item rincian
            </div>
          </td>
          <td style="text-align:right; font-weight:700; color:var(--text-primary);">
            {{ $item->formatted_total }}
          </td>
          <td style="text-align:center;">
            <span class="badge {{ $item->status_badge_class }}">
              {{ $item->status_label }}
            </span>
          </td>
          <td>
            <div style="display:flex; gap:6px; justify-content:center;">
              <a href="{{ route('admin.invoices.show', $item->id) }}" class="btn btn-sm" style="background:var(--primary-light); color:var(--primary); padding:6px 9px;" title="Lihat Detail">
                <i class="fas fa-eye"></i>
              </a>
              <a href="{{ route('admin.invoices.print', $item->id) }}" target="_blank" class="btn btn-sm" style="background:rgba(255,255,255,0.06); color:white; padding:6px 9px;" title="Cetak / PDF">
                <i class="fas fa-print"></i>
              </a>
              <a href="{{ route('admin.invoices.edit', $item->id) }}" class="btn btn-sm" style="background:rgba(245, 158, 11, 0.15); color:var(--warning); padding:6px 9px;" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              @if($item->status !== 'paid')
                <form action="{{ route('admin.invoices.status', $item->id) }}" method="POST" style="margin:0" onsubmit="return confirm('Tandai Invoice {{ $item->number }} sebagai LUNAS?')">
                  @csrf
                  @method('PATCH')
                  <input type="hidden" name="status" value="paid">
                  <button type="submit" class="btn btn-sm" style="background:rgba(16, 185, 129, 0.15); color:var(--success); padding:6px 9px;" title="Tandai Lunas">
                    <i class="fas fa-check-double"></i>
                  </button>
                </form>
              @endif
              <form action="{{ route('admin.invoices.destroy', $item->id) }}" method="POST" style="margin:0" onsubmit="return confirm('Yakin ingin menghapus Invoice ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm" style="background:rgba(239, 68, 68, 0.15); color:var(--danger); padding:6px 9px;" title="Hapus">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="7" style="text-align:center; padding:3rem 1rem; color:var(--text-secondary);">
            <i class="fas fa-file-invoice" style="font-size:2.5rem; opacity:0.3; margin-bottom:0.75rem; display:block;"></i>
            Belum ada Invoice yang diterbitkan.
            <div style="margin-top:0.75rem;">
              <a href="{{ route('admin.invoices.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Terbitkan Invoice Pertama</a>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($invoices->hasPages())
  <div class="card-footer" style="padding:1rem 1.5rem;">
    {{ $invoices->links() }}
  </div>
  @endif
</div>
@endsection
