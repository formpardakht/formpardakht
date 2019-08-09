<?php

namespace App\Http\Controllers;

use App\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\User;
use Illuminate\Support\Facades\DB;

class InstallController extends Controller
{
    public function index()
    {
        if (!$this->isAllowed()) {
            return redirect()->route('login');
        }

        return view('install.index');
    }

    public function install(Request $request)
    {
        if (!$this->isAllowed()) {
            return redirect()->route('login');
        }

        $rules = [
            'site_url' => 'required|url',
            'site_title' => 'required|max:255',
            'site_description' => 'required|max:255',
            'db_host' => 'required',
            'db_name' => 'required',
            'db_username' => 'required',
            'db_password' => 'required',
            'admin_email' => 'required|email',
            'admin_password' => 'required|min:6',
        ];
        $this->validate($request, $rules);

        $env = file_get_contents(base_path('.env.example'));
        $env = str_replace('{SITE_URL}', $request->site_url, $env);
        $env = str_replace('{DB_HOST}', $request->db_host, $env);
        $env = str_replace('{DB_NAME}', $request->db_name, $env);
        $env = str_replace('{DB_USERNAME}', $request->db_username, $env);
        $env = str_replace('{DB_PASSWORD}', $request->db_password, $env);

        file_put_contents(base_path('.env'), $env);

        return redirect()->route('install-complete')
            ->withInput($request->all());
    }

    public function showComplete()
    {
        if (!$this->isAllowed()) {
            return redirect()->route('login');
        }

        return view('install.complete');
    }

    public function complete(Request $request)
    {
        if (!$this->isAllowed()) {
            return redirect()->route('login');
        }

        $rules = [
            'site_url' => 'required|url',
            'site_title' => 'required|max:255',
            'site_description' => 'required|max:255',
            'admin_email' => 'required|email',
            'admin_password' => 'required|min:6',
        ];
        $this->validate($request, $rules);

        try {
            Artisan::call('migrate:refresh', ['--force' => '--force']);
            Artisan::call('key:generate');

            return DB::transaction(function () use ($request) {
                User::create([
                    'name' => 'مدیر سیستم',
                    'email' => $request->admin_email,
                    'password' => bcrypt($request->admin_password),
                ]);

                Config::create([
                    'key' => 'site_url',
                    'value' => $request->site_url,
                    'label' => 'آدرس سایت',
                ]);
                Config::create([
                    'key' => 'site_title',
                    'value' => $request->site_title,
                    'label' => 'عنوان سایت',
                ]);
                Config::create([
                    'key' => 'site_description',
                    'value' => $request->site_description,
                    'label' => 'توضیحات سایت',
                ]);

                Artisan::call('db:seed', ['--force' => '--force']);

                return redirect()->to('login');
            });
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('install')
                ->with('alert', 'danger')
                ->with('message', $e->getMessage());
        }
    }

    private function isAllowed()
    {
        try {
            if (site_config('site_url')) {
                return false;
            }
        } catch (\Exception $e) {
            //
        }

        return true;
    }
}
