<?php

namespace Beebmx\Panel\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Beebmx\Panel\Blueprint;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{

    public function index()
    {
        $settings = [
            'base'  => config('panel.prefix'),
            'links' => config('panel.links'),
            'logo'  => asset(config('panel.logo')),
            'name'  => config('panel.name'),
            'url'   => url(config('panel.prefix')),
        ];
        $list = $this->getList();
        return response()->json(compact('settings', 'list'));
    }

    protected function getList()
    {
        $profile = $profile = Auth::user()->profile;
        $admin = (int)$profile->is_admin ? true : false;

        return Blueprint::getListModels($admin);
    }
}
