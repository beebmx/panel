<?php

namespace Beebmx\Panel\Http\Controllers;

use App\Http\Controllers\Controller;
use Beebmx\Panel\Features\Blueprintable;
use Beebmx\Panel\Http\Resources\BlueprintDataCollection;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class PanelModelController extends Controller
{
    use Blueprintable;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function index(Request $request, $model)
    {
        $model = $this->getBlueprint($model);
        $fields = $model->getFields()->getSettings();
        $permissions = $model->data()->getPermissions();

        $headers = $model->data()->getHeaders();
        return response()->json(compact('permissions', 'fields', 'headers'));
    }

    public function data(Request $request, $model)
    {
        $model = $this->getBlueprint($model);
        $data = $model->data()->all();
        
        return new BlueprintDataCollection($data);
    }

    public function create()
    {
    }
    
    public function store()
    {
    }

    public function edit(Request $request, $model)
    {
        $model = $this->getBlueprint($model);
    }

    public function update()
    {
    }

    public function destroy()
    {
    }
}
