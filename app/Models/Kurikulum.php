<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Kurikulum extends Model
{
    protected $table = 'kurikulum';
    public $timestamps = false;

    protected $fillable = ['nama_mapel', 'modul_url', 'roadmap_url', 'harga', 'fitur', 'badge', 'urutan', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('aktif', 1)->orderBy('urutan');
    }
}
