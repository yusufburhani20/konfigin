<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'logo_url',
        'url',
        'urutan',
        'aktif'
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', 1);
    }
}
