<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Config;

class ConfigController extends Controller
{
    public function index()
    {
        $configs = Config::where('visible', '=', 1)->get();

        return view('fp::admin.configs.index')
            ->with('activeMenu', 'configs')
            ->with('configs', $configs);
    }

    public function edit(Request $request)
    {
        if (app()->environment() === 'demo') {
            return redirect()->back()
                ->with('alert', 'warning')
                ->with('message', lang('lang.demo_mode'));
        }
        
        $inputs = $request->input();

        foreach ($inputs as $key => $value) {
            Config::where('key', '=', $key)->update([
                'value' => $value,
            ]);
        }

        return redirect()->back()
            ->with('alert', 'success')
            ->with('message', lang('lang.changes_saved'));
    }
}
