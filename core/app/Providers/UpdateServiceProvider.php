<?php

namespace App\Providers;

use App\Config;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\FileViewFinder;
use Illuminate\Support\Facades\View;

class UpdateServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $lastCheck = Config::where('key', '=', 'update_last_check')->first();
            if (!$lastCheck) {
                $lastCheck = Config::create([
                    'key' => 'update_last_check',
                    'value' => '',
                    'label' => 'آخرین بررسی بروزرسانی',
                    'visible' => false,
                ]);
            }

            $newRelease = Config::where('key', '=', 'update_new_release')->first();
            if (!$newRelease) {
                $newRelease = Config::create([
                    'key' => 'update_new_release',
                    'value' => '',
                    'label' => 'نسخه جدید در دسترس',
                    'visible' => false,
                ]);
            }

            if (!$lastCheck->value || date_diff_in_days(new \Carbon\Carbon($lastCheck->value), new \Carbon\Carbon('now'))) {
                $latestRelease = $this->latestRelease();
                $lastCheck->update([
                    'value' => date('Y-m-d H:i:s'),
                ]);

                if (isset($latestRelease->version) && version_compare($latestRelease->version, config('app.version')) > 0) {
                    $newRelease->update(['value' => $latestRelease->version]);
                }
            }
        } catch (\Exception $e) {
            //
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function latestRelease()
    {
        $latestRelease = curl_get(config('app.update_url'));

        if ($latestRelease) {
            if (isset($latestRelease->version) && version_compare($latestRelease->version, config('app.version')) > 0) {
                return $latestRelease;
            }
        }

        return null;
    }
}
