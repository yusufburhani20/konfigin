<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $table = 'kontak';
    public $timestamps = false;

    protected $fillable = ['email', 'whatsapp', 'website', 'alamat', 'maps_embed'];

    public static function first(): ?static
    {
        return static::query()->first();
    }

    /**
     * Format nomor WhatsApp ke format internasional
     */
    public function getWhatsappFormattedAttribute(): string
    {
        $clean = preg_replace('/[^0-9]/', '', $this->whatsapp ?? '');
        if (str_starts_with($clean, '0')) {
            $clean = '62' . substr($clean, 1);
        }
        return $clean;
    }

    /**
     * Format URL website
     */
    public function getWebsiteFormattedAttribute(): string
    {
        $url = $this->website ?? '';
        if (empty($url) || $url === '#') return '#';
        if (!preg_match('/^https?:\/\//i', $url)) {
            $url = 'https://' . ltrim($url, '/');
        }
        return $url;
    }
}
