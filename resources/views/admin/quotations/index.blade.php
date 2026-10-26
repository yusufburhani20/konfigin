@extends('admin.layout')

@section('title', 'Surat Penawaran (Quotation)')
@section('page_title', 'Surat Penawaran Harga')
@section('page_subtitle', 'Kelola penawaran solusi IT, quotation harga klien, dan konversi ke invoice')

@section('content')
<div class="card">
  <div class="card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
    <div>
      <h2 class="card-title"><i class="fas fa-file-contract" style="color:var(--primary); margin-right:8px;"></i>Daftar Surat Penawaran</h2>
    </div>
    <div style="display:flex; gap:0.75rem; align-items:center;">
      <a href="{{ route('admin.quotations.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Buat Penawaran Baru
      </a>
    </div>
  </div>

  <div class="card-body" style="padding-bottom: 0;">
    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('admin.quotations.index') }}" style="display:flex; gap:0.75rem; flex-wrap:wrap; margin-bottom:1.5rem;">
      <div style="flex:1; min-width:240px;">
        <input type="text" name="search" class="form-input" placeholder="Cari nomor surat, perihal, nama klien..." value="{{ request('search') }}">
      </div>
      <div style="min-width:160px;">
        <select name="status" class="form-input" onchange="this.form.submit()">
          <option value="">Semua Status</option>
          <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
          <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Terkirim</option>
          <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Disetujui</option>
          <option value="converted" {{ request('status') === 'converted' ? 'selected' : '' }}>Dikonversi ke Invoice</option>
          <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
        </select>
      </div>
      <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i> Cari</button>
      @if(request()->hasAny(['search', 'status']))
        <a href="{{ route('admin.quotations.index') }}" class="btn btn-secondary btn-sm" title="Reset Filter"><i class="fas fa-times"></i> Reset</a>
      @endif
    </form>
  </div>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>No. Penawaran</th>
          <th>Tanggal &amp; Berlaku</th>
          <th>Klien / Perusahaan</th>
          <th>Perihal / Proyek</th>
          <th style="text-align:right;">Total Nilai</th>
          <th style="text-align:center;">Status</th>
          <th width="190" style="text-align:center;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($quotations as $item)
        <tr>
          <td>
            <a href="{{ route('admin.quotations.show', $item->id) }}" style="font-weight:700; color:var(--primary); text-decoration:none;">
              {{ $item->number }}
            </a>
            @if($item->invoices->count() > 0)
              <div style="font-size:0.72rem; color:var(--text-secondary); margin-top:2px;">
                <i class="fas fa-link"></i> Inv: {{ $item->invoices->pluck('number')->join(', ') }}
              </div>
            @endif
          </td>
          <td>
            <div style="font-weight:500;">{{ $item->date ? $item->date->format('d M Y') : '-' }}</div>
            <div style="font-size:0.75rem; color:var(--text-secondary);">
              s/d {{ $item->due_date ? $item->due_date->format('d M Y') : '-' }}
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
              {{ $item->items->count() }} item layanan
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
              <a href="{{ route('admin.quotations.show', $item->id) }}" class="btn btn-sm" style="background:var(--primary-light); color:var(--primary); padding:6px 9px;" title="Lihat Detail">
                <i class="fas fa-eye"></i>
              </a>
              <a href="{{ route('admin.quotations.print', $item->id) }}" target="_blank" class="btn btn-sm" style="background:rgba(255,255,255,0.06); color:white; padding:6px 9px;" title="Cetak / Simpan PDF">
                <i class="fas fa-print"></i>
              </a>
              <a href="{{ route('admin.quotations.edit', $item->id) }}" class="btn btn-sm" style="background:rgba(245, 158, 11, 0.15); color:var(--warning); padding:6px 9px;" title="Edit">
                <i class="fas fa-edit"></i>
              </a>
              @if($item->status !== 'converted')
                <form action="{{ route('admin.quotations.convert', $item->id) }}" method="POST" style="margin:0" onsubmit="return confirm('Konversi surat penawaran ini menjadi Invoice tagihan resmi?')">
                  @csrf
                  <button type="submit" class="btn btn-sm" style="background:rgba(16, 185, 129, 0.15); color:var(--success); padding:6px 9px;" title="Jadikan Invoice">
                    <i class="fas fa-exchange-alt"></i>
                  </button>
                </form>
              @endif
              <form action="{{ route('admin.quotations.destroy', $item->id) }}" method="POST" style="margin:0" onsubmit="return confirm('Yakin ingin menghapus Surat Penawaran ini?')">
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
            <i class="fas fa-file-contract" style="font-size:2.5rem; opacity:0.3; margin-bottom:0.75rem; display:block;"></i>
            Belum ada Surat Penawaran yang dibuat.
            <div style="margin-top:0.75rem;">
              <a href="{{ route('admin.quotations.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Buat Surat Penawaran Pertama</a>
            </div>
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($quotations->hasPages())
  <div class="card-footer" style="padding:1rem 1.5rem;">
    {{ $quotations->links() }}
  </div>
  @endif
</div>
@endsection
