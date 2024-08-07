<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use App\Traits\Slugable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Setting extends Model
{
    use HasFactory, Slugable, LogsActivity;

    protected $guarded = [];

    public function getLogo()
    {
        return asset(!empty($this->value) ? \constPath::SystemLogo . $this->value : \constPath::DefaultImage);
    }

    /**
     * Grab a setting value from the database.
     *
     * @param string $key The setting key, as defined in the key db column
     *
     * @return string The setting value.
     */
    public static function get($key)
    {
        $setting = new self();
        $entry = $setting->where('key', $key)->first();

        if (!$entry) {
            return;
        }

        return $entry->value;
    }

    /**
     * Update a setting's value.
     *
     * @param string $key The setting key, as defined in the key db column
     * @param string $value The new value.
     * @return bool
     */
    public static function set($key, $value = null)
    {
        $prefixed_key = 'settings.' . $key;
        $setting = new self();
        $entry = $setting->where('key', $key)->firstOrFail();

        // update the value in the database
        $entry->value = $value;
        $entry->saveOrFail();

        // update the value in the session
        Config::set($prefixed_key, $value);

        if (Config::get($prefixed_key) == $value) {
            return true;
        }

        return false;
    }
}
