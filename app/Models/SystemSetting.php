<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type', 'description'];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        if (!$setting) return $default;

        return match ($setting->type) {
            'boolean' => (bool) $setting->value,
            'number' => is_numeric($setting->value) ? (float) $setting->value : $setting->value,
            'json' => json_decode($setting->value, true),
            default => $setting->value,
        };
    }

    public static function set($key, $value, $group = 'general', $type = 'string')
    {
        if ($type === 'json') $value = json_encode($value);
        return static::updateOrCreate(['key' => $key], [
            'value' => $value,
            'group' => $group,
            'type' => $type,
        ]);
    }
}
