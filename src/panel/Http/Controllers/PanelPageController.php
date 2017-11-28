<?php

namespace Beebmx\Panel\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Guard;
use Beebmx\Panel\Blueprint;

class PanelPageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
		$this->auth = $auth;
    }
    
    public function index(Request $request)
    {
        
    }
}
