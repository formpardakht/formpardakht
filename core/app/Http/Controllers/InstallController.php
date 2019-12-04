<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstallRequest;
use App\Services\InstallService;

class InstallController extends Controller
{
    /**
     * @var InstallService
     */
    protected $installService;

    /**
     * InstallController constructor.
     * @param InstallService $installService
     * @throws \Exception
     */
    public function __construct(InstallService $installService)
    {
        $this->installService = $installService;

        if (!$this->isAllowed()) {
            return redirect()->route('login');
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('install.index');
    }

    /**
     * @param InstallRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function install(InstallRequest $request)
    {
        if (!$this->isAllowed()) {
            return redirect()->route('login');
        }

        $this->installService->install($request);

        return view('install.complete')->with([
            'inputs' => $request->input()
        ]);
    }

    /**
     * @return bool
     * @throws \Exception
     */
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
