<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;

class CheckInstallation
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        // check old database for version 2.6.0
        try {
            $siteUrl = DB::table('configs')->where('key', '=', 'site_url')->first();
            if ($siteUrl) {
                return $next($request);
            }
        } catch (\Exception $e) {
            //
        }

        try {
            if (site_config('site_url')) {
                return $next($request);
            }
        } catch (\Exception $e) {
            if ($e->getCode() == '42S02' || $e->getCode() == '1045') {
                return redirect()->route('install');
            }

            throw $e;
        }

        return redirect()->route('install');
    }
}
