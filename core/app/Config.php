<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fp_configs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        $config = self::where('key', $key)->first();

        if ($config) {
            return $config->value;
        }

        return null;
    }

    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function set($key, $value)
    {
        $config = self::where('key', $key)->first();

        if ($config) {
            $config->update([
                'value' => $value
            ]);
        } else {
            $config = self::create([
                'key' => $key,
                'value' => $value
            ]);
        }

        return $config;
    }
}
