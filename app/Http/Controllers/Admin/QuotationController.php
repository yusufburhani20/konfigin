<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentItem;
use App\Models\Client;
use App\Models\Setting;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::quotations()->with(['items', 'client', 'invoices']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                  ->orWhere('title', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%")
                  ->orWhere('client_company', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $quotations = $query->latest('date')->latest('id')->paginate(15)->withQueryString();

        return view('admin.quotations.index', compact('quotations'));
    }

    public function create()
    {
        $number = Document::generateNumber('quotation');
        $clients = Client::aktif()->orderBy('name')->get();
        $settings = Setting::allAsArray();

        $defaultTerms = "1. Masa berlaku penawaran harga ini adalah 14 (empat belas) hari sejak tanggal diterbitkan.\n"
            . "2. Harga belum termasuk PPN 11% kecuali dinyatakan lain secara tertulis.\n"
            . "3. Pembayaran dilakukan secara bertahap: DP 50% setelah penandatanganan kesepakatan, dan pelunasan 50% setelah serah terima proyek (UAT selesai).\n"
            . "4. Waktu pengerjaan dihitung sejak DP diterima dan materi/kebutuhan awal telah lengkap.\n"
            . "5. Termasuk garansi perbaikan bug dan pendampingan (maintenance) selama 3 (tiga) bulan.";

        $defaultNotes = "Terima kasih atas kesempatan dan kepercayaan yang diberikan kepada kami untuk mengajukan penawaran solusi teknologi informasi.";

        return view('admin.quotations.form', [
            'document' => new Document([
                'type' => 'quotation',
                'number' => $number,
                'date' => now()->format('Y-m-d'),
                'due_date' => now()->addDays(14)->format('Y-m-d'),
                'status' => 'draft',
                'terms' => $defaultTerms,
                'notes' => $defaultNotes,
                'signer_name' => $settings['signer_name'] ?? session('admin_nama', 'Yusuf Burhani'),
                'signer_title' => $settings['signer_title'] ?? 'Lead IT Consultant / Direktur',
            ]),
            'clients' => $clients,
            'isEdit' => false,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateDocument($request);

        DB::beginTransaction();
        try {
            $calc = $this->calculateTotals($request);

            $document = Document::create(array_merge($validated, [
                'type' => 'quotation',
                'subtotal' => $calc['subtotal'],
                'discount_amount' => $calc['discount_amount'],
                'tax_amount' => $calc['tax_amount'],
                'total' => $calc['total'],
                'created_by' => session('admin_id'),
            ]));

            $this->saveItems($document, $request->input('items', []));

            DB::commit();
            return redirect()->route('admin.quotations.index')
                ->with('success', 'Surat Penawaran ' . $document->number . ' berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan penawaran: ' . $e->getMessage());
        }
    }

    public function show(Document $quotation)
    {
        $quotation->load(['items', 'client', 'reference', 'invoices']);
        $settings = Setting::allAsArray();
        $kontak = Kontak::first();

        return view('admin.quotations.show', compact('quotation', 'settings', 'kontak'));
    }

    public function edit(Document $quotation)
    {
        $quotation->load('items');
        $clients = Client::aktif()->orderBy('name')->get();

        return view('admin.quotations.form', [
            'document' => $quotation,
            'clients' => $clients,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Document $quotation)
    {
        $validated = $this->validateDocument($request, $quotation->id);

        DB::beginTransaction();
        try {
            $calc = $this->calculateTotals($request);

            $quotation->update(array_merge($validated, [
                'subtotal' => $calc['subtotal'],
                'discount_amount' => $calc['discount_amount'],
                'tax_amount' => $calc['tax_amount'],
                'total' => $calc['total'],
            ]));

            // Hapus item lama dan simpan yang baru
            $quotation->items()->delete();
            $this->saveItems($quotation, $request->input('items', []));

            DB::commit();
            return redirect()->route('admin.quotations.index')
                ->with('success', 'Surat Penawaran ' . $quotation->number . ' berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui penawaran: ' . $e->getMessage());
        }
    }

    public function destroy(Document $quotation)
    {
        try {
            $number = $quotation->number;
            $quotation->delete();
            return redirect()->route('admin.quotations.index')
                ->with('success', 'Surat Penawaran ' . $number . ' berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus penawaran: ' . $e->getMessage());
        }
    }

    public function print(Document $quotation)
    {
        $quotation->load(['items', 'client']);
        $settings = Setting::allAsArray();
        $kontak = Kontak::first();

        return view('admin.documents.print', [
            'document' => $quotation,
            'settings' => $settings,
            'kontak' => $kontak,
        ]);
    }

    /**
     * Konversi Surat Penawaran menjadi Invoice otomatis
     */
    public function convert(Document $quotation)
    {
        DB::beginTransaction();
        try {
            $invNumber = Document::generateNumber('invoice');

            $defaultBank = "Pembayaran dapat ditransfer melalui:\n"
                . "Bank BCA : 054-082-9911\n"
                . "A.n.     : Yusuf Burhani\n"
                . "Cabang   : Tasikmalaya\n\n"
                . "Harap sertakan nomor invoice pada berita transfer.";

            $invoice = Document::create([
                'type' => 'invoice',
                'number' => $invNumber,
                'reference_id' => $quotation->id,
                'client_id' => $quotation->client_id,
                'title' => $quotation->title ?? 'Tagihan untuk ' . $quotation->number,
                'client_name' => $quotation->client_name,
                'client_company' => $quotation->client_company,
                'client_address' => $quotation->client_address,
                'client_phone' => $quotation->client_phone,
                'client_email' => $quotation->client_email,
                'date' => now()->format('Y-m-d'),
                'due_date' => now()->addDays(7)->format('Y-m-d'),
                'subtotal' => $quotation->subtotal,
                'discount_type' => $quotation->discount_type,
                'discount_value' => $quotation->discount_value,
                'discount_amount' => $quotation->discount_amount,
                'tax_percent' => $quotation->tax_percent,
                'tax_amount' => $quotation->tax_amount,
                'total' => $quotation->total,
                'status' => 'unpaid',
                'notes' => $quotation->notes,
                'terms' => "1. Pembayaran jatuh tempo 7 hari sejak tanggal invoice diterbitkan.\n2. Konfirmasi bukti pembayaran melalui WhatsApp atau email resmi Konfigin.",
                'payment_info' => $defaultBank,
                'signer_name' => $quotation->signer_name,
                'signer_title' => $quotation->signer_title,
                'created_by' => session('admin_id'),
            ]);

            // Salin item
            foreach ($quotation->items as $item) {
                DocumentItem::create([
                    'document_id' => $invoice->id,
                    'item_name' => $item->item_name,
                    'description' => $item->description,
                    'quantity' => $item->quantity,
                    'unit' => $item->unit,
                    'price' => $item->price,
                    'amount' => $item->amount,
                    'sort_order' => $item->sort_order,
                ]);
            }

            // Update status quotation
            $quotation->update(['status' => 'converted']);

            DB::commit();
            return redirect()->route('admin.invoices.show', $invoice->id)
                ->with('success', "Berhasil mengonversi {$quotation->number} menjadi Invoice {$invoice->number}!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal konversi ke invoice: ' . $e->getMessage());
        }
    }

    private function validateDocument(Request $request, $id = null): array
    {
        return $request->validate([
            'number' => 'required|string|max:50|unique:documents,number,' . $id,
            'title' => 'nullable|string|max:255',
            'client_id' => 'nullable|exists:clients,id',
            'client_name' => 'required|string|max:255',
            'client_company' => 'nullable|string|max:255',
            'client_address' => 'nullable|string',
            'client_phone' => 'nullable|string|max:50',
            'client_email' => 'nullable|email|max:100',
            'date' => 'required|date',
            'due_date' => 'nullable|date',
            'discount_type' => 'required|in:fixed,percent',
            'discount_value' => 'nullable|numeric|min:0',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
            'status' => 'required|string|in:draft,sent,accepted,rejected,converted',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
            'signer_name' => 'nullable|string|max:100',
            'signer_title' => 'nullable|string|max:100',
            'items' => 'required|array|min:1',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.unit' => 'nullable|string|max:50',
            'items.*.price' => 'required|numeric|min:0',
        ]);
    }

    private function calculateTotals(Request $request): array
    {
        $subtotal = 0;
        foreach ($request->input('items', []) as $item) {
            $qty = (float) ($item['quantity'] ?? 1);
            $price = (float) ($item['price'] ?? 0);
            $subtotal += ($qty * $price);
        }

        $discountType = $request->input('discount_type', 'fixed');
        $discountValue = (float) $request->input('discount_value', 0);
        $discountAmount = 0;

        if ($discountType === 'percent') {
            $discountAmount = ($subtotal * min(100, $discountValue)) / 100;
        } else {
            $discountAmount = min($subtotal, $discountValue);
        }

        $afterDiscount = max(0, $subtotal - $discountAmount);
        $taxPercent = (float) $request->input('tax_percent', 0);
        $taxAmount = ($afterDiscount * $taxPercent) / 100;
        $total = $afterDiscount + $taxAmount;

        return [
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'total' => $total,
        ];
    }

    private function saveItems(Document $document, array $items): void
    {
        $sort = 0;
        foreach ($items as $item) {
            $qty = (float) ($item['quantity'] ?? 1);
            $price = (float) ($item['price'] ?? 0);
            $amount = $qty * $price;

            DocumentItem::create([
                'document_id' => $document->id,
                'item_name' => $item['item_name'],
                'description' => $item['description'] ?? null,
                'quantity' => $qty,
                'unit' => $item['unit'] ?? 'Paket',
                'price' => $price,
                'amount' => $amount,
                'sort_order' => $sort++,
            ]);
        }
    }
}
