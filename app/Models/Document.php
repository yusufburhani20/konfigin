<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'type',
        'number',
        'reference_id',
        'client_id',
        'title',
        'app_description',
        'client_name',
        'client_company',
        'client_address',
        'client_phone',
        'client_email',
        'date',
        'due_date',
        'subtotal',
        'discount_type',
        'discount_value',
        'discount_amount',
        'tax_percent',
        'tax_amount',
        'total',
        'status',
        'notes',
        'terms',
        'payment_info',
        'signer_name',
        'signer_title',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_percent' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(DocumentItem::class)->orderBy('sort_order', 'asc');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function reference(): BelongsTo
    {
        return $this->belongsTo(Document::class, 'reference_id');
    }

    public function relatedInvoices(): HasMany
    {
        return $this->hasMany(Document::class, 'reference_id')->where('type', 'invoice');
    }

    public function scopeQuotations($query)
    {
        return $query->where('type', 'quotation');
    }

    public function scopeInvoices($query)
    {
        return $query->where('type', 'invoice');
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getFormattedDiscountAttribute(): string
    {
        return 'Rp ' . number_format($this->discount_amount, 0, ',', '.');
    }

    public function getFormattedTaxAttribute(): string
    {
        return 'Rp ' . number_format($this->tax_amount, 0, ',', '.');
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'paid', 'accepted' => 'badge-success',
            'sent', 'unpaid' => 'badge-warning',
            'draft' => 'badge-secondary',
            'converted' => 'badge-info',
            'cancelled', 'rejected' => 'badge-danger',
            default => 'badge-secondary'
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'sent' => 'Terkirim',
            'accepted' => 'Disetujui',
            'rejected' => 'Ditolak',
            'converted' => 'Dikonversi ke Inv',
            'unpaid' => 'Belum Lunas',
            'paid' => 'Lunas',
            'partial' => 'Sebagian',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status)
        };
    }

    /**
     * Konversi angka nominal ke kalimat Terbilang dalam Rupiah
     */
    public function getTerbilangAttribute(): string
    {
        $nilai = (int) round($this->total);
        if ($nilai <= 0) return 'Nol Rupiah';
        return trim(self::penyebut($nilai)) . ' Rupiah';
    }

    private static function penyebut($nilai): string
    {
        $nilai = abs($nilai);
        $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = self::penyebut($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $temp = self::penyebut((int)($nilai / 10)) . " Puluh" . self::penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " Seratus" . self::penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = self::penyebut((int)($nilai / 100)) . " Ratus" . self::penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " Seribu" . self::penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = self::penyebut((int)($nilai / 1000)) . " Ribu" . self::penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = self::penyebut((int)($nilai / 1000000)) . " Juta" . self::penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = self::penyebut((int)($nilai / 1000000000)) . " Milyar" . self::penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = self::penyebut((int)($nilai / 1000000000000)) . " Trilyun" . self::penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    /**
     * Generate Nomor Dokumen Otomatis (Format: SP/YYYY/MM/0001 atau INV/YYYY/MM/0001)
     */
    public static function generateNumber(string $type): string
    {
        $prefix = ($type === 'quotation') ? 'SP' : 'INV';
        $year = date('Y');
        $month = date('m');
        $pattern = "{$prefix}/{$year}/{$month}/%";

        $lastDoc = self::where('type', $type)
            ->where('number', 'like', $pattern)
            ->orderBy('id', 'desc')
            ->first();

        $seq = 1;
        if ($lastDoc && preg_match('/\/(\d+)$/', $lastDoc->number, $matches)) {
            $seq = ((int) $matches[1]) + 1;
        }

        return sprintf("%s/%s/%s/%04d", $prefix, $year, $month, $seq);
    }
}
