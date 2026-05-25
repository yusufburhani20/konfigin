<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Eservice extends Model
{
    protected $table = 'eservice';
    public $timestamps = false;

    protected $fillable = ['nama', 'url', 'deskripsi', 'icon', 'warna', 'urutan', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('aktif', 1)->orderBy('urutan');
    }
}
