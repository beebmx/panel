<?php

namespace Beebmx\Panel\Http\Controllers;

use App\Http\Controllers\Controller;

class PanelController extends Controller
{

    public function index()
    {
        return view('panel::app');
    }
}
