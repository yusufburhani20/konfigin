@extends('admin.layout')

@section('title', $isEdit ? 'Edit Invoice' : 'Terbitkan Invoice Baru')
@section('page_title', $isEdit ? 'Edit Invoice: ' . $document->number : 'Terbitkan Invoice Baru')
@section('page_subtitle', 'Kelola rincian tagihan, nomor rekening pembayaran, dan jatuh tempo')

@section('content')
<form action="{{ $isEdit ? route('admin.invoices.update', $document->id) : route('admin.invoices.store') }}" method="POST" id="invoice-form">
  @csrf
  @if($isEdit)
    @method('PUT')
  @endif

  <div style="display:grid; grid-template-columns: 2fr 1fr; gap:1.5rem; align-items:start;">
    
    {{-- KOLOM KIRI --}}
    <div style="display:flex; flex-direction:column; gap:1.5rem;">
      
      {{-- Card Identitas Invoice & Klien --}}
      <div class="card">
        <div class="card-header">
          <h2 class="card-title"><i class="fas fa-file-invoice" style="color:var(--primary); margin-right:8px;"></i>Informasi Tagihan &amp; Klien</h2>
        </div>
        <div class="card-body">
          <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem;">
            <div class="form-group">
              <label class="form-label" for="number">Nomor Invoice <span style="color:var(--danger)">*</span></label>
              <input type="text" id="number" name="number" class="form-input" value="{{ old('number', $document->number) }}" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="title">Perihal Tagihan / Proyek <span style="color:var(--danger)">*</span></label>
              <input type="text" id="title" name="title" class="form-input" placeholder="Contoh: Pembayaran Termin 1 / Pelunasan Sistem" value="{{ old('title', $document->title) }}" required>
            </div>
          </div>

          <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem; margin-top:0.5rem;">
            <div class="form-group">
              <label class="form-label" for="date">Tanggal Invoice <span style="color:var(--danger)">*</span></label>
              <input type="date" id="date" name="date" class="form-input" value="{{ old('date', $document->date ? $document->date->format('Y-m-d') : date('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
              <label class="form-label" for="due_date">Tanggal Jatuh Tempo <span style="color:var(--danger)">*</span></label>
              <input type="date" id="due_date" name="due_date" class="form-input" value="{{ old('due_date', $document->due_date ? $document->due_date->format('Y-m-d') : date('Y-m-d', strtotime('+7 days'))) }}" required>
            </div>
          </div>

          <div style="border-top:1px solid var(--border); margin:1.25rem 0; padding-top:1.25rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.75rem;">
              <h3 style="font-size:0.95rem; font-weight:600; color:var(--text-primary);"><i class="fas fa-user-tag" style="color:var(--secondary); margin-right:6px;"></i>Data Penerima Tagihan (Klien)</h3>
              @if($clients->count() > 0)
                <div style="display:flex; align-items:center; gap:0.5rem;">
                  <span style="font-size:0.8rem; color:var(--text-secondary);">Pilih dari Partner:</span>
                  <select id="client_selector" class="form-input" style="padding:4px 8px; font-size:0.8rem; width:auto;">
                    <option value="">-- Isi Manual / Pilih Klien --</option>
                    @foreach($clients as $c)
                      <option value="{{ $c->id }}" data-name="{{ $c->name }}">{{ $c->name }}</option>
                    @endforeach
                  </select>
                </div>
              @endif
            </div>

            <input type="hidden" name="client_id" id="client_id" value="{{ old('client_id', $document->client_id) }}">

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem;">
              <div class="form-group">
                <label class="form-label" for="client_name">Nama Kontak / PIC <span style="color:var(--danger)">*</span></label>
                <input type="text" id="client_name" name="client_name" class="form-input" placeholder="Nama Bpk/Ibu PIC" value="{{ old('client_name', $document->client_name) }}" required>
              </div>
              <div class="form-group">
                <label class="form-label" for="client_company">Nama Perusahaan / Instansi</label>
                <input type="text" id="client_company" name="client_company" class="form-input" placeholder="PT / CV / Lembaga" value="{{ old('client_company', $document->client_company) }}">
              </div>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:1rem; margin-top:0.5rem;">
              <div class="form-group">
                <label class="form-label" for="client_phone">No. Telepon / WhatsApp</label>
                <input type="text" id="client_phone" name="client_phone" class="form-input" placeholder="08xxxxxxxxxx" value="{{ old('client_phone', $document->client_phone) }}">
              </div>
              <div class="form-group">
                <label class="form-label" for="client_email">Alamat Email Klien</label>
                <input type="email" id="client_email" name="client_email" class="form-input" placeholder="finance@perusahaan.com" value="{{ old('client_email', $document->client_email) }}">
              </div>
            </div>

            <div class="form-group" style="margin-top:0.5rem;">
              <label class="form-label" for="client_address">Alamat Klien / Instansi</label>
              <textarea id="client_address" name="client_address" class="form-input" rows="2" placeholder="Jl. ...">{{ old('client_address', $document->client_address) }}</textarea>
            </div>
          </div>
        </div>
      </div>

      {{-- Card Rincian Item Tagihan --}}
      <div class="card">
        <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
          <h2 class="card-title"><i class="fas fa-list-ol" style="color:var(--primary); margin-right:8px;"></i>Rincian Tagihan Layanan / Barang</h2>
          <button type="button" class="btn btn-primary btn-sm" id="btn-add-item">
            <i class="fas fa-plus"></i> Tambah Item
          </button>
        </div>
        <div class="card-body" style="padding:0;">
          <div class="table-responsive">
            <table class="doc-items-table" id="items-table">
              <thead>
                <tr>
                  <th width="40">#</th>
                  <th>Uraian Tagihan</th>
                  <th width="90">Jumlah</th>
                  <th width="100">Satuan</th>
                  <th width="160">Harga Satuan (Rp)</th>
                  <th width="160">Total (Rp)</th>
                  <th width="50" style="text-align:center;">Hapus</th>
                </tr>
              </thead>
              <tbody id="items-body">
                @php
                  $oldItems = old('items', $document->items->count() > 0 ? $document->items->toArray() : [
                    ['item_name' => '', 'description' => '', 'quantity' => 1, 'unit' => 'Paket', 'price' => 0]
                  ]);
                @endphp

                @foreach($oldItems as $idx => $item)
                <tr class="item-row" data-index="{{ $idx }}">
                  <td style="color:var(--text-secondary); font-size:0.85rem; padding-top:1.1rem;" class="row-num">{{ $loop->iteration }}</td>
                  <td>
                    <input type="text" name="items[{{ $idx }}][item_name]" class="form-input item-name" placeholder="Nama Layanan / Tagihan Termin" value="{{ $item['item_name'] ?? '' }}" required style="font-weight:600;">
                    <textarea name="items[{{ $idx }}][description]" class="form-input" rows="2" placeholder="Detail keterangan / periode tagihan (opsional)" style="margin-top:6px; font-size:0.85rem;">{{ $item['description'] ?? '' }}</textarea>
                  </td>
                  <td>
                    <input type="number" step="any" min="0.01" name="items[{{ $idx }}][quantity]" class="form-input item-qty" value="{{ $item['quantity'] ?? 1 }}" required style="text-align:center;">
                  </td>
                  <td>
                    <input type="text" name="items[{{ $idx }}][unit]" class="form-input" value="{{ $item['unit'] ?? 'Paket' }}" placeholder="Paket / Bulan">
                  </td>
                  <td>
                    <input type="number" step="1" min="0" name="items[{{ $idx }}][price]" class="form-input item-price" value="{{ (int)($item['price'] ?? 0) }}" required style="text-align:right;">
                  </td>
                  <td>
                    <input type="text" class="form-input item-amount-display" readonly style="text-align:right; font-weight:600; background:rgba(255,255,255,0.02);" value="0">
                  </td>
                  <td style="text-align:center;">
                    <button type="button" class="btn btn-sm btn-remove-item" style="background:rgba(239, 68, 68, 0.15); color:var(--danger); padding:6px 10px;">
                      <i class="fas fa-trash"></i>
                    </button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      {{-- Card Deskripsi Aplikasi (TinyEditor) --}}
      <div class="card">
        <div class="card-header" style="display:flex; justify-content:space-between; align-items:center;">
          <h2 class="card-title">
            <i class="fas fa-laptop-code" style="color:var(--primary); margin-right:8px;"></i>Deskripsi Aplikasi &amp; Spesifikasi Teknis
          </h2>
          <span style="font-size:0.8rem; color:var(--text-secondary); background:rgba(255,255,255,0.05); padding:4px 8px; border-radius:4px;">
            <i class="fas fa-table" style="margin-right:4px;"></i>TinyEditor (Tabel &amp; Formatter)
          </span>
        </div>
        <div class="card-body">
          <div class="form-group" style="margin-bottom:0;">
            <label class="form-label" for="app_description">
              Rincian Modul, Fitur &amp; Spesifikasi Teknis Aplikasi <span style="font-size:0.8rem; color:var(--text-secondary); font-weight:normal;">(Opsional - Tampil di lembar cetak invoice)</span>
            </label>
            <textarea id="app_description" name="app_description" class="form-input" rows="12">{{ old('app_description', $document->app_description) }}</textarea>
            <div class="form-help" style="margin-top:8px;">
              Anda dapat menyusun detail aplikasi, membuat tabel modul fitur, daftar spesifikasi hosting/database, maupun rincian deliverables invoice ini.
            </div>
          </div>
        </div>
      </div>

      {{-- Card Instruksi Pembayaran & Rekening --}}
      <div class="card">
        <div class="card-header">
          <h2 class="card-title"><i class="fas fa-university" style="color:var(--primary); margin-right:8px;"></i>Informasi Rekening &amp; Catatan</h2>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label" for="payment_info">Instruksi Pembayaran &amp; Rekening Bank <span style="color:var(--text-secondary); font-size:0.8rem; font-weight:normal;">(Opsional)</span></label>
            <textarea id="payment_info" name="payment_info" class="form-input" rows="4" style="font-family:monospace; font-size:0.85rem;" placeholder="Kosongkan jika tagihan sudah lunas atau tidak memerlukan info transfer bank">{{ old('payment_info', $document->payment_info) }}</textarea>
            <div class="form-help">Informasi nomor rekening bank resmi. Kosongkan jika invoice sudah lunas.</div>
          </div>
          <div class="form-group" style="margin-top:1rem;">
            <label class="form-label" for="terms">Syarat &amp; Ketentuan Tagihan</label>
            <textarea id="terms" name="terms" class="form-input" rows="3" style="font-family:monospace; font-size:0.85rem;">{{ old('terms', $document->terms) }}</textarea>
          </div>
          <div class="form-group" style="margin-top:1rem;">
            <label class="form-label" for="notes">Catatan Tambahan</label>
            <textarea id="notes" name="notes" class="form-input" rows="2">{{ old('notes', $document->notes) }}</textarea>
          </div>
        </div>
      </div>

    </div>

    {{-- KOLOM KANAN --}}
    <div style="display:flex; flex-direction:column; gap:1.5rem;">
      
      {{-- Card Perhitungan Total Tagihan --}}
      <div class="card">
        <div class="card-header">
          <h2 class="card-title"><i class="fas fa-calculator" style="color:var(--primary); margin-right:8px;"></i>Perhitungan Tagihan</h2>
        </div>
        <div class="card-body">
          <div class="doc-calc-box">
            <div class="doc-calc-row">
              <span style="color:var(--text-secondary);">Subtotal:</span>
              <span id="display-subtotal" style="font-weight:600; font-size:1rem;">Rp 0</span>
            </div>

            {{-- Diskon --}}
            <div style="border-top:1px solid var(--border); padding-top:0.75rem;">
              <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.4rem;">
                <span style="color:var(--text-secondary); font-size:0.85rem;">Diskon / Potongan:</span>
                <div style="display:flex; gap:4px;">
                  <select name="discount_type" id="discount_type" class="form-input" style="padding:2px 6px; font-size:0.78rem; width:auto;">
                    <option value="fixed" {{ old('discount_type', $document->discount_type) === 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                    <option value="percent" {{ old('discount_type', $document->discount_type) === 'percent' ? 'selected' : '' }}>Persen (%)</option>
                  </select>
                </div>
              </div>
              <div style="display:flex; gap:0.5rem; align-items:center;">
                <input type="number" step="any" min="0" name="discount_value" id="discount_value" class="form-input" value="{{ old('discount_value', (int)$document->discount_value) }}" style="text-align:right;">
                <span id="display-discount-amount" style="min-width:100px; text-align:right; font-size:0.85rem; color:var(--text-secondary);">-Rp 0</span>
              </div>
            </div>

            {{-- Pajak PPN --}}
            <div style="border-top:1px solid var(--border); padding-top:0.75rem;">
              <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.4rem;">
                <span style="color:var(--text-secondary); font-size:0.85rem;">Pajak PPN (%):</span>
                <input type="number" step="any" min="0" max="100" name="tax_percent" id="tax_percent" class="form-input" value="{{ old('tax_percent', (int)$document->tax_percent) }}" style="width:70px; text-align:center; padding:4px 6px;">
              </div>
              <div style="display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:0.8rem; color:var(--text-secondary);">Nominal PPN:</span>
                <span id="display-tax-amount" style="font-weight:500; font-size:0.9rem;">+Rp 0</span>
              </div>
            </div>

            {{-- Grand Total --}}
            <div class="doc-calc-row grand-total">
              <span>Total Tagihan:</span>
              <span id="display-total">Rp 0</span>
            </div>
          </div>
        </div>
      </div>

      {{-- Card Status Tagihan & Penandatangan --}}
      <div class="card">
        <div class="card-header">
          <h2 class="card-title"><i class="fas fa-stamp" style="color:var(--primary); margin-right:8px;"></i>Status &amp; Tanda Tangan</h2>
        </div>
        <div class="card-body">
          <div class="form-group">
            <label class="form-label" for="status">Status Pembayaran</label>
            <select name="status" id="status" class="form-input" required>
              <option value="unpaid" {{ old('status', $document->status) === 'unpaid' ? 'selected' : '' }}>Belum Lunas (Unpaid)</option>
              <option value="paid" {{ old('status', $document->status) === 'paid' ? 'selected' : '' }}>LUNAS (Paid)</option>
              <option value="draft" {{ old('status', $document->status) === 'draft' ? 'selected' : '' }}>Draft (Konsep)</option>
              <option value="cancelled" {{ old('status', $document->status) === 'cancelled' ? 'selected' : '' }}>Dibatalkan (Cancelled)</option>
            </select>
          </div>

          <div class="form-group" style="margin-top:1rem;">
            <label class="form-label" for="signer_name">Nama Penandatangan</label>
            <input type="text" id="signer_name" name="signer_name" class="form-input" value="{{ old('signer_name', $document->signer_name) }}">
          </div>

          <div class="form-group" style="margin-top:0.75rem;">
            <label class="form-label" for="signer_title">Jabatan Penandatangan</label>
            <input type="text" id="signer_title" name="signer_title" class="form-input" value="{{ old('signer_title', $document->signer_title) }}">
          </div>

          <div style="border-top:1px solid var(--border); margin-top:1.5rem; padding-top:1.25rem; display:flex; flex-direction:column; gap:0.75rem;">
            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:0.85rem;">
              <i class="fas fa-save"></i> {{ $isEdit ? 'Simpan Perubahan Invoice' : 'Terbitkan Invoice' }}
            </button>
            <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary" style="width:100%; justify-content:center;">
              Batal
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const itemsBody = document.getElementById('items-body');
  const btnAddItem = document.getElementById('btn-add-item');
  const discountType = document.getElementById('discount_type');
  const discountValue = document.getElementById('discount_value');
  const taxPercent = document.getElementById('tax_percent');
  const clientSelector = document.getElementById('client_selector');

  let itemIndex = document.querySelectorAll('.item-row').length;

  function formatRp(num) {
    return 'Rp ' + Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }

  function recalculateAll() {
    let subtotal = 0;
    const rows = document.querySelectorAll('.item-row');

    rows.forEach((row, idx) => {
      row.querySelector('.row-num').innerText = idx + 1;
      const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
      const price = parseFloat(row.querySelector('.item-price').value) || 0;
      const amount = qty * price;
      subtotal += amount;
      row.querySelector('.item-amount-display').value = formatRp(amount);
    });

    document.getElementById('display-subtotal').innerText = formatRp(subtotal);

    // Diskon
    const dType = discountType.value;
    const dVal = parseFloat(discountValue.value) || 0;
    let dAmount = 0;
    if (dType === 'percent') {
      dAmount = (subtotal * Math.min(100, dVal)) / 100;
    } else {
      dAmount = Math.min(subtotal, dVal);
    }
    document.getElementById('display-discount-amount').innerText = '- ' + formatRp(dAmount);

    // Pajak
    const afterDiscount = Math.max(0, subtotal - dAmount);
    const tPercent = parseFloat(taxPercent.value) || 0;
    const tAmount = (afterDiscount * tPercent) / 100;
    document.getElementById('display-tax-amount').innerText = '+ ' + formatRp(tAmount);

    // Total
    const total = afterDiscount + tAmount;
    document.getElementById('display-total').innerText = formatRp(total);
  }

  itemsBody.addEventListener('input', function(e) {
    if (e.target.classList.contains('item-qty') || e.target.classList.contains('item-price')) {
      recalculateAll();
    }
  });

  discountType.addEventListener('change', recalculateAll);
  discountValue.addEventListener('input', recalculateAll);
  taxPercent.addEventListener('input', recalculateAll);

  itemsBody.addEventListener('click', function(e) {
    const btn = e.target.closest('.btn-remove-item');
    if (btn) {
      const rows = document.querySelectorAll('.item-row');
      if (rows.length <= 1) {
        alert('Minimal harus ada satu item rincian tagihan.');
        return;
      }
      btn.closest('.item-row').remove();
      recalculateAll();
    }
  });

  btnAddItem.addEventListener('click', function() {
    const tr = document.createElement('tr');
    tr.className = 'item-row';
    tr.dataset.index = itemIndex;
    tr.innerHTML = `
      <td style="color:var(--text-secondary); font-size:0.85rem; padding-top:1.1rem;" class="row-num"></td>
      <td>
        <input type="text" name="items[${itemIndex}][item_name]" class="form-input item-name" placeholder="Nama Layanan / Tagihan Termin" required style="font-weight:600;">
        <textarea name="items[${itemIndex}][description]" class="form-input" rows="2" placeholder="Detail keterangan / periode tagihan (opsional)" style="margin-top:6px; font-size:0.85rem;"></textarea>
      </td>
      <td>
        <input type="number" step="any" min="0.01" name="items[${itemIndex}][quantity]" class="form-input item-qty" value="1" required style="text-align:center;">
      </td>
      <td>
        <input type="text" name="items[${itemIndex}][unit]" class="form-input" value="Paket" placeholder="Paket / Bulan">
      </td>
      <td>
        <input type="number" step="1" min="0" name="items[${itemIndex}][price]" class="form-input item-price" value="0" required style="text-align:right;">
      </td>
      <td>
        <input type="text" class="form-input item-amount-display" readonly style="text-align:right; font-weight:600; background:rgba(255,255,255,0.02);" value="Rp 0">
      </td>
      <td style="text-align:center;">
        <button type="button" class="btn btn-sm btn-remove-item" style="background:rgba(239, 68, 68, 0.15); color:var(--danger); padding:6px 10px;">
          <i class="fas fa-trash"></i>
        </button>
      </td>
    `;
    itemsBody.appendChild(tr);
    itemIndex++;
    recalculateAll();
  });

  if (clientSelector) {
    clientSelector.addEventListener('change', function() {
      const selected = clientSelector.options[clientSelector.selectedIndex];
      if (selected.value) {
        document.getElementById('client_id').value = selected.value;
        document.getElementById('client_company').value = selected.dataset.name || '';
      }
    });
  }

  recalculateAll();
});
</script>

<!-- TinyEditor untuk Deskripsi Aplikasi -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#app_description',
    height: 420,
    menubar: 'edit insert view format table tools help',
    plugins: [
      'advlist', 'autolink', 'lists', 'link', 'charmap', 'preview',
      'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
      'insertdatetime', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks fontfamily fontsize | ' +
      'bold italic underline forecolor backcolor | alignleft aligncenter ' +
      'alignright alignjustify | bullist numlist outdent indent | ' +
      'table tableinsertdialog tabledelete | removeformat | code fullscreen',
    table_default_attributes: {
      border: '1'
    },
    table_default_styles: {
      'border-collapse': 'collapse',
      'width': '100%'
    },
    table_responsive_width: true,
    content_style: 'body { font-family: Inter, -apple-system, BlinkMacSystemFont, sans-serif; font-size: 14px; line-height: 1.6; color: #1e293b; background: #ffffff; padding: 12px; } table { border-collapse: collapse; width: 100%; margin-bottom: 1rem; } th, td { border: 1px solid #cbd5e1; padding: 8px 12px; } th { background-color: #f1f5f9; font-weight: 600; text-align: left; }',
    branding: false,
    promotion: false,
    setup: function (editor) {
      editor.on('change', function () {
        editor.save();
      });
    }
  });

  const invForm = document.querySelector('form');
  if (invForm) {
    invForm.addEventListener('submit', function () {
      if (typeof tinymce !== 'undefined') {
        tinymce.triggerSave();
      }
    });
  }
</script>
@endsection
