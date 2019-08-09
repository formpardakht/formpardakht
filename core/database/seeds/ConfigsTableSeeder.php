<?php

use Illuminate\Database\Seeder;
use App\Config;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::create([
            'key' => 'payir_api_key',
            'value' => 'test',
            'label' => 'Pay.ir API Key'
        ]);
        Config::create([
            'key' => 'live_stats',
            'value' => false,
            'label' => lang('lang.live_stats'),
            'visible' => 0
        ]);
    }
}
