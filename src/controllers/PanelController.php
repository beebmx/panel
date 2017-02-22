<?php

namespace Beebmx\Panel;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Auth\Guard;
use Beebmx\Panel\Blueprint;
use Beebmx\Panel\RenderData;
use Beebmx\Panel\FilesPanel;
use Validator;
use Session;

class PanelController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Guard $auth){
		$this->auth = $auth;
    }
    
    public function dashboard(){
        return view('panel::dashboard', []);
    }
    
    public function index(Request $request, $model, $parent_id = null, $children = null){
        $q = $request->has('q') ? $request->input('q') : false;
        $parent = null;
        if ($children !== null){
            $parent = $model;
            $model = $children;
        }
        if ($model = $this->getBlueprint($model)){
            $is_allowed = false;
            if ($model->admin){
                $profile = $this->auth->user()->profile;
                if ((int)$profile->is_admin){
                    $is_allowed = true;
                }
            }else{
                $is_allowed = true;
            }
            if ($is_allowed){
                foreach($model->fields as $id => $field){
                    $model->fields[$id]['mobile'] = isset($field['mobile']) ? $field['mobile'] : true;
                }
                if ($children === null){
                    $data = $model->all($request);
                }else{
                    $data = $model->allForeign($request, $parent_id);
                }
                $render = new RenderData($model, $data);
                return view('panel::index', ['model'     => $model,
                                             'parent_id' => $parent_id,
                                             'parent'    => $parent,
                                             'fields'    => $model->getListHeaders(),
                                             'data'      => $data,
                                             'list'      => $render->index(),
                                             'idField'   => $model->getIdField(),
                                             'q'         => $q]);
            }else{
                return response()->view('panel::error', ['error' => 401], 401);
            }
        }else{
            return response()->view('panel::error', ['error' => 404], 404);
        }
    }
    
    public function create($model, $parent_id = null, $children = null){
        $parent = null;
        if ($children !== null){
            $parent = $model;
            $model = $children;
        }
        if ($model = $this->getBlueprint($model)){
            $render = new RenderData($model, null, Session::get('errors'));
            return view('panel::form', ['model'        => $model,
                                        'parent_id'    => $parent_id,
                                        'parent'       => $parent,
                                        'fields'       => $render->form(),
                                        'modals'       => $render->modal(),
                                        'resource_css' => $render->css(),
                                        'resource_js'  => $render->js(),
                                        'files'        => [],
                                        'method'       => 'post']);
        }else{
            return response()->view('panel::error', ['error' => 404], 404);
        }
    }
    public function store(Request $request, $model, $parent_id = null, $children = null){
        $parent = null;
        if ($children !== null){
            $parent = $model;
            $model = $children;
        }
        if ($model = $this->getBlueprint($model)){
            $input = $request->only($model->only());
            $this->validate($request, $model->getValidations($input));
            if ($children !== null){
                $input[$model->getForeign()] = $parent_id;
            }
            $id = $model->insert($input);
            if ($model->supportFiles()){
                $files = json_decode($request->input('files'), true);
                FilesPanel::process($files, $model, true);
            }
            if ($children === null){
                return redirect()->route('panel.edit', ['model' => $model->url, 'id' => $id]);
            }else{
                return redirect()->route('panel.children.edit', ['model' => $parent, 'parent_id' => $parent_id, 'children' => $model->url, 'id' => $id]);
            }
        }else{
            return response()->view('panel::error', ['error' => 404], 404);
        }
    }
    
    public function show($model, $id, $children = null, $children_id = null){
        $parent = null;
        if ($children !== null){
            $parent = $model;
            $model = $children;
        }
        if ($model = $this->getBlueprint($model)){
            if ($children === null){
                $record = $model->find($id);
            } else {
                $record = $model->find($children_id);
            }
            $render = new RenderData($model, $record, Session::get('errors'));
            return view('panel::view', ['model'        => $model,
                                        'children_id'  => $children_id,
                                        'parent_id'    => $id,
                                        'parent'       => $parent,
                                        'fields'       => $render->view(),
                                        'modals'       => $render->modal(),
                                        'resource_css' => $render->css(),
                                        'resource_js'  => $render->js(),
                                        'files'        => FilesPanel::get($model)]);
        }else{
            return response()->view('panel::error', ['error' => 404], 404);
        }
    }
    
    public function edit($model, $id, $children = null, $children_id = null){
        $parent = null;
        if ($children !== null){
            $parent = $model;
            $model = $children;
        }
        if ($model = $this->getBlueprint($model)){
            if ($children === null){
                $record = $model->find($id);
            } else {
                $record = $model->find($children_id);
            }
            $render = new RenderData($model, $record, Session::get('errors'));
            return view('panel::form', ['model'        => $model,
                                        'children_id'  => $children_id,
                                        'parent_id'    => $id,
                                        'parent'       => $parent,
                                        'fields'       => $render->form(),
                                        'modals'       => $render->modal(),
                                        'resource_css' => $render->css(),
                                        'resource_js'  => $render->js(),
                                        'files'        => FilesPanel::get($model),
                                        'method'       => 'put']);
        }else{
            return response()->view('panel::error', ['error' => 404], 404);
        }
    }
    
    public function update(Request $request, $model, $id, $children = null, $children_id = null){
        $parent = null;
        if ($children !== null){
            $parent = $model;
            $model = $children;
        }
        if ($model = $this->getBlueprint($model)){
            if ($children === null){
                $model->setId($id);
            } else {
                $model->setId($children_id);
            }
            $input = $request->only($model->only());
            $this->validate($request, $model->getValidations($input));
            if ($children !== null){
                $input[$model->getForeign()] = $id;
            }
            $record = $model->update($input);
            if ($model->supportFiles()){
                $files = json_decode($request->input('files'), true);
                FilesPanel::process($files, $model);
            }
            if ($children === null){
                return redirect()->route('panel.edit', ['model' => $model->url, 'id' => $id]);
            }else{
                return redirect()->route('panel.children.edit', ['model' => $parent, 'parent_id' => $id, 'children' => $children, 'id' => $children_id]);
            }
        }else{
            return response()->view('panel::error', ['error' => 404], 404);
        }
    }
    
    public function destroy(Request $request, $model, $id, $children = null, $children_id = null){
        $parent = null;
        if ($children !== null){
            $parent = $model;
            $model = $children;
        }
        if ($model = $this->getBlueprint($model)){
            if ($children === null){
                $model->setId($id);
            } else {
                $model->setId($children_id);
            }
            $record = $model->delete();
            return redirect()->back();
        }else{
            return response()->view('panel::error', ['error' => 404], 404);
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
