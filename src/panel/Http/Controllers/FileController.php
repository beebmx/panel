<?php

namespace Beebmx\Panel\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Guard;
use Beebmx\Panel\Blueprint;
use Beebmx\Panel\FilePanel;
use Validator;
use Session;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth){
		$this->auth = $auth;
    }
    
    public function upload(Request $request){
        $input = $request->only('model', 'id');
        $id = (int) $input['id'];
        if ($model = $this->getBlueprint($input['model'])){
            $model->setId($id);
            $file = FilePanel::store($request->file('file'), $model);
            
            return response()->json(array('success' => true, 'message' => 'Archivo cargado', 'model' => $input['model'],
                                          'name' => $request->file('file')->getClientOriginalName(),
                                          'storage' => $model->storage, 'file' => $file, 'id' => $id));
        }else{
            return response()->json(array('success' => false, 'message' => 'El modelo no existe'));
        }
    }
    
    private function getBlueprint($model){
        if (Blueprint::exists($model)){
            return new Blueprint(Blueprint::path($model));
        }else{
            return false;
        }
    }
}
