<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Keunggulan extends Model
{
    protected $table = 'keunggulan';
    public $timestamps = false;

    protected $fillable = ['icon', 'judul', 'deskripsi', 'urutan', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('aktif', 1)->orderBy('urutan');
    }
}
