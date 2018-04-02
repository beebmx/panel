<?php

namespace Beebmx\Panel\Http\Controllers;

use App\Http\Controllers\Controller;
use Beebmx\Panel\Features\Blueprintable;
use Beebmx\Panel\Http\Resources\BlueprintDataCollection;
use Beebmx\Panel\Http\Resources\BlueprintParentCollection;
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
        $permissions = $model->data()->getPermissions();
        $fields = $model->fields()->getSettings();
        $headers = $model->data()->getHeaders();
        $files = $model->files()->getSettings();
        $name = $model->name;

        return response()->json(compact('permissions', 'fields', 'headers', 'files', 'name'));
    }

    public function data(Request $request, $model, $parent = false)
    {
        $model = $this->getBlueprint($model);
        $data = $model->data($parent)->all();

        return new BlueprintDataCollection($data);
    }

    public function show(Request $request, $model, $id)
    {
        $model = $this->getBlueprint($model);
        $models = $model->data()->getAllRelatinshipsData();
        $data = $model->data()->find($id);

        return response()->json(compact('models', 'data'));
    }

    public function store($model, $parent = false)
    {
        $model = $this->getBlueprint($model);
        $data = $model->data($parent)->save();

        return response()->json(compact('data'));
    }

    public function update($model, $id)
    {
        $model = $this->getBlueprint($model);
        $data = $model->data()->save($id);

        return response()->json(compact('data'));
    }

    public function destroy($model, $id)
    {
        $model = $this->getBlueprint($model);
        $record = $model->data()->delete($id);

        return response()->json(compact('record'));
    }

    public function parent()
    {
        $model = request()->input('model');
        $model = $model::all();

        return new BlueprintParentCollection($model);
    }
}
