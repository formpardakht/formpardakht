<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use ZipArchive;

class UpdateController extends Controller
{
    public function index()
    {
        $latestRelease = $this->latestRelease();

        return view('fp::admin.update.index')
            ->with('activeMenu', 'update')
            ->with('latestRelease', $latestRelease);
    }

    public function install()
    {
        ini_set('max_execution_time', '3000');
        $latestRelease = $this->latestRelease();
        if ($latestRelease) {
            if (isset($latestRelease->version) && version_compare($latestRelease->version, config('app.version')) > 0) {
                try {
                    $file = file_get_contents($latestRelease->url, false);
                    if (file_exists(base_path('../tmp'))) {
                        File::deleteDirectory(base_path('../tmp'));
                    }
                    mkdir(base_path('../tmp'));
                    file_put_contents(base_path('/../tmp/update.zip'), $file);
                    $zip = new ZipArchive;
                    if ($zip->open(base_path('/../tmp/update.zip'))) {
                        $zip->extractTo(base_path('/../tmp'));
                        $zip->close();
                        copy(base_path('update-installer.php'), base_path('/../update-installer.php'));

                        return redirect(site_config('site_url') . '/update-installer.php?finishUrl=' . site_config('site_url') . '/admin/update/finish');
                    }
                } catch (\Exception $e) {
                    dd($e->getMessage());
                    return handle_exception($e);
                }
            }

            return redirect()->back()
                ->with('alert', 'info')
                ->with('message', lang('lang.you_are_using_latest_version'));
        }

        return redirect()->back()
            ->with('alert', 'warning')
            ->with('message', lang('lang.no_update_available'));
    }

    public function finish()
    {
        Artisan::call('migrate');

        $this->cleanUpRoot();

        return redirect()->route('admin-update')
            ->with('alert', 'success')
            ->with('message', lang('lang.updated'));
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

    private function cleanUpRoot()
    {
        if (file_exists(base_path('../css'))) {
            File::deleteDirectory(base_path('../css'));
        }
        if (file_exists(base_path('../js'))) {
            File::deleteDirectory(base_path('../js'));
        }
        if (file_exists(base_path('../fonts'))) {
            File::deleteDirectory(base_path('../fonts'));
        }
        if (file_exists(base_path('../libs'))) {
            File::deleteDirectory(base_path('../libs'));
        }
        if (file_exists(base_path('../tmp'))) {
            File::deleteDirectory(base_path('../tmp'));
        }
    }
}
