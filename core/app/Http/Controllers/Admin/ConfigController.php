<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Config;
use Illuminate\Support\Facades\DB;

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

    public function scripts(Request $request)
    {
        $scripts = Config::where('key', '=', 'scripts')->first();
        if (!$scripts) {
            $scripts = Config::create(['key' => 'scripts', 'value' => '']);
        }

        $scripts->update(['value' => $request->scripts]);

        return redirect()->back()
            ->with('alert', 'success')
            ->with('message', lang('lang.changes_saved'));
    }

    public function styles(Request $request)
    {
        $styles = Config::where('key', '=', 'styles')->first();
        if (!$styles) {
            $styles = Config::create(['key' => 'styles', 'value' => '']);
        }

        $styles->update(['value' => $request->styles]);

        return redirect()->back()
            ->with('alert', 'success')
            ->with('message', lang('lang.changes_saved'));
    }
}
