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

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Document::invoices()->with(['items', 'client', 'reference']);

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

        $invoices = $query->latest('date')->latest('id')->paginate(15)->withQueryString();

        // Rekapitulasi ringkas
        $totalPaid = Document::invoices()->where('status', 'paid')->sum('total');
        $totalUnpaid = Document::invoices()->whereIn('status', ['unpaid', 'partial', 'sent'])->sum('total');
        $countUnpaid = Document::invoices()->whereIn('status', ['unpaid', 'partial', 'sent'])->count();

        return view('admin.invoices.index', compact('invoices', 'totalPaid', 'totalUnpaid', 'countUnpaid'));
    }

    public function create()
    {
        $number = Document::generateNumber('invoice');
        $clients = Client::aktif()->orderBy('name')->get();
        $settings = Setting::allAsArray();

        $defaultBank = "Pembayaran dapat ditransfer melalui rekening resmi:\n"
            . "Seabank : 901177915949\n"
            . "A.n.    : Yusuf Burhani\n\n"
            . "Harap konfirmasikan bukti transfer dengan menyertakan Nomor Invoice ini.";

        $defaultTerms = "1. Pembayaran jatuh tempo selambat-lambatnya 7 (tujuh) hari kerja sejak tanggal invoice diterbitkan.\n"
            . "2. Keterlambatan pembayaran dapat mengakibatkan penundaan layanan/akses sistem.\n"
            . "3. Bukti pembayaran resmi hanya diakui apabila dana telah efektif masuk ke rekening yang tertera.";

        return view('admin.invoices.form', [
            'document' => new Document([
                'type' => 'invoice',
                'number' => $number,
                'date' => now()->format('Y-m-d'),
                'due_date' => now()->addDays(7)->format('Y-m-d'),
                'status' => 'unpaid',
                'payment_info' => $defaultBank,
                'terms' => $defaultTerms,
                'notes' => 'Terima kasih atas kerja samanya dalam proyek pengembangan ini.',
                'signer_name' => $settings['signer_name'] ?? session('admin_nama', 'Yusuf Burhani'),
                'signer_title' => $settings['signer_title'] ?? 'Founder Konfigin IT Solutions',
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
                'type' => 'invoice',
                'subtotal' => $calc['subtotal'],
                'discount_amount' => $calc['discount_amount'],
                'tax_amount' => $calc['tax_amount'],
                'total' => $calc['total'],
                'created_by' => session('admin_id'),
            ]));

            $this->saveItems($document, $request->input('items', []));

            DB::commit();
            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice ' . $document->number . ' berhasil diterbitkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan invoice: ' . $e->getMessage());
        }
    }

    public function show(Document $invoice)
    {
        $invoice->load(['items', 'client', 'reference']);
        $settings = Setting::allAsArray();
        $kontak = Kontak::first();

        return view('admin.invoices.show', compact('invoice', 'settings', 'kontak'));
    }

    public function edit(Document $invoice)
    {
        $invoice->load('items');
        $clients = Client::aktif()->orderBy('name')->get();

        return view('admin.invoices.form', [
            'document' => $invoice,
            'clients' => $clients,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Document $invoice)
    {
        $validated = $this->validateDocument($request, $invoice->id);

        DB::beginTransaction();
        try {
            $calc = $this->calculateTotals($request);

            $invoice->update(array_merge($validated, [
                'subtotal' => $calc['subtotal'],
                'discount_amount' => $calc['discount_amount'],
                'tax_amount' => $calc['tax_amount'],
                'total' => $calc['total'],
            ]));

            $invoice->items()->delete();
            $this->saveItems($invoice, $request->input('items', []));

            DB::commit();
            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice ' . $invoice->number . ' berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui invoice: ' . $e->getMessage());
        }
    }

    public function destroy(Document $invoice)
    {
        try {
            $number = $invoice->number;
            $invoice->delete();
            return redirect()->route('admin.invoices.index')
                ->with('success', 'Invoice ' . $number . ' berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus invoice: ' . $e->getMessage());
        }
    }

    public function print(Document $invoice)
    {
        $invoice->load(['items', 'client', 'reference']);
        $settings = Setting::allAsArray();
        $kontak = Kontak::first();

        return view('admin.documents.print', [
            'document' => $invoice,
            'settings' => $settings,
            'kontak' => $kontak,
        ]);
    }

    /**
     * Update Status Cepat (misal: Tandai Lunas)
     */
    public function updateStatus(Request $request, Document $invoice)
    {
        $request->validate([
            'status' => 'required|in:draft,unpaid,partial,paid,cancelled'
        ]);

        $invoice->update(['status' => $request->status]);

        return redirect()->back()->with('success', "Status Invoice {$invoice->number} diubah menjadi: " . $invoice->status_label);
    }

    private function validateDocument(Request $request, $id = null): array
    {
        return $request->validate([
            'number' => 'required|string|max:50|unique:documents,number,' . $id,
            'title' => 'nullable|string|max:255',
            'app_description' => 'nullable|string',
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
            'status' => 'required|string|in:draft,unpaid,partial,paid,cancelled',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
            'payment_info' => 'nullable|string',
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
