<?php

namespace Beebmx\Panel\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Beebmx\Panel\Http\Resources\BlueprintFileCollection;
use Beebmx\Panel\Features\Blueprintable;

class FilesController extends Controller
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

    public function all($model, $id)
    {
        $model = $this->getBlueprint($model);
        $files = $model->files()->setId($id)->all();

        return new BlueprintFileCollection($files);
    }

    public function upload($model, $id = null)
    {
        $model = $this->getBlueprint($model);
        $files = $model->files()->save();

        return new BlueprintFileCollection($files);
    }

    public function process($model, $id)
    {
        $model = $this->getBlueprint($model);
        $files = $model->files()->setId($id)->process();

        return new BlueprintFileCollection($files);
    }

    public function reverse($model, $id = false)
    {
        $model = $this->getBlueprint($model);
        $files = $model->files()->setId($id)->reverse();

        return response()->json(compact('files'));
    }
}
