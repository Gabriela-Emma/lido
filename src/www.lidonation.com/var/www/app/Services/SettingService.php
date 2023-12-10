<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Fluent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\QueryException;

class SettingService
{
    public function getSettings(): Fluent
    {

        try {

            $settings = Cache::remember('snippets', now()->addHours(12), function () {
                return Setting::all(['key', 'value'])->map(function ($snippet) {
                    return [
                        $snippet->key => $snippet->value,
                    ];
                });
            });

            return new Fluent($settings->collapse()->toArray());
        } catch (QueryException $e) {
            report($e);
        }

        return new Fluent([]);
    }

    public function saveSetting(string $setting, $value)
    {
        return Setting::updateOrCreate(
            [
                'key' => $setting,
            ],
            [
                'key' => $setting,
                'value' => $value,
            ]
        );
    }
}
