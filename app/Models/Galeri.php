<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Galeri extends Model
{
    protected $table = 'galeri';
    public $timestamps = false;

    protected $fillable = ['judul', 'foto_url', 'instagram_url', 'urutan', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('aktif', 1)->orderBy('urutan');
    }
}
