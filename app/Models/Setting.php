<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['setting_key', 'setting_value'];

    /**
     * Get setting value by key with optional default
     */
    public static function get(string $key, string $default = ''): string
    {
        $row = static::where('setting_key', $key)->first();
        return $row ? ($row->setting_value ?? $default) : $default;
    }

    /**
     * Set / upsert a setting value
     */
    public static function set(string $key, string $value): void
    {
        static::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value]
        );
    }

    /**
     * Get all settings as key=>value array
     */
    public static function allAsArray(): array
    {
        return static::all()->pluck('setting_value', 'setting_key')->toArray();
    }
}
