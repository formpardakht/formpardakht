<?php

namespace App\Services;

use App\Config;
use App\Http\Requests\InstallRequest;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InstallService
{
    /**
     * @param InstallRequest $request
     * @throws ValidationException
     */
    public function install(InstallRequest $request)
    {
        $this->checkDB($request);

        try {
            $sampleConfig = require(base_path('config-sample.php'));
            foreach ($sampleConfig as $key => $value) {
                $sampleConfig[$key] = '"' . $value . '",';
            }
            $sampleConfig['APP_URL'] = '"' . $request->site_url . '",';
            $sampleConfig['DB_HOST'] = '"' . $request->db_host . '",';
            $sampleConfig['DB_DATABASE'] = '"' . $request->db_name . '",';
            $sampleConfig['DB_USERNAME'] = '"' . $request->db_username . '",';
            $sampleConfig['DB_PASSWORD'] = '"' . $request->db_password . '",';

            $config = print_r($sampleConfig, true);
            $config = str_replace("[", '"', $config);
            $config = str_replace("]", '"', $config);

            file_put_contents(base_path('config.php'), '<?php return ' . $config . ';');

            Artisan::call('migrate:refresh', ['--force' => '--force']);
            Artisan::call('key:generate');

            DB::transaction(function () use ($request) {
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
            });
        } catch (\Exception $e) {
            if ($e->getCode() == 1045) {
                throw ValidationException::withMessages(['install' => 'اطلاعات ورود دیتابیس اشتباه می باشد']);
            } else {
                throw ValidationException::withMessages(['install' => $e->getMessage()]);
            }
        }
    }

    /**
     * @param InstallRequest $request
     * @throws ValidationException
     */
    private function checkDB(InstallRequest $request)
    {
        try {
            $conn = new \mysqli($request->db_host, $request->db_username, $request->db_password, $request->db_name);
            if ($conn->connect_error) {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            throw ValidationException::withMessages(['install' => 'اطلاعات دیتابیس اشتباه می باشد']);
        }
    }
}