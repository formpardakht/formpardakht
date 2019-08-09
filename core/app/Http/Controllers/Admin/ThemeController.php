<?php

namespace App\Http\Controllers\Admin;

use App\Config;
use App\Http\Controllers\Controller;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = [];
        $themesDirectories = glob(base_path('../themes') . '/*', GLOB_ONLYDIR);
        foreach ($themesDirectories as $directory) {
            if (file_exists($directory . '/theme.json')) {
                $theme = file_get_contents($directory . '/theme.json');
                $theme = json_decode($theme, true);
                if (isset($theme['slug']) && isset($theme['name']) && isset($theme['version']) && isset($theme['author'])) {
                    if (file_exists($directory . '/screenshot.jpg')) {
                        $theme['screenshot'] = asset('themes/' . $theme['slug'] . '/screenshot.jpg');
                    }
                    array_push($themes, $theme);
                }
            }
        }

        return view('fp::admin.themes.index')
            ->with('activeMenu', 'themes')
            ->with('themes', $themes);
    }

    public function update($slug)
    {
        if (file_exists(base_path('../themes/' . $slug) . '/theme.json')) {
            Config::where('key', '=', 'theme')->update([
                'value' => $slug,
            ]);

            return redirect()->back()
                ->with('alert', 'success')
                ->with('message', lang('lang.theme_changed'));
        }

        return redirect()->back()
            ->with('alert', 'danger')
            ->with('message', lang('lang.theme_not_found'));
    }
}
