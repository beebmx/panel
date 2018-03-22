<?php

namespace Beebmx\Panel\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Beebmx\Panel\Features\Blueprintable;

class PanelModelControllerOld extends Controller
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

    public function index(Request $request, $model, $parent_id = null, $children = null)
    {
        if ($model = $this->getBlueprint($model)) {
            $fields = $model->getFields();
            $data = $model->data()->all();
            $permissions = $model->data()->getPermissions();

            $headers = $this->getHeaders($fields->all());
            $rows = $this->getRows($data, $headers, $fields);

            return view('panel::model.index', compact('model', 'permissions', 'headers', 'data', 'rows'));
        }
        else {
            return response()->view('panel::error', ['error' => 404], 404);
        }
    }

    public function create()
    {
        
    }
    
    public function store()
    {
        
    }

    public function edit()
    {
        
    }

    public function update()
    {
        
    }

    public function destroy()
    {
        
    }

    protected function getHeaders($fields)
    {
        return collect($fields)->filter(function($field, $id) {
            return $field->list;
        })->map(function ($field, $id) {
            return collect($field->attributes)->only('id', 'label', 'cell', 'mobile', 'parent');
        });
    }

    protected function getRows($data, $headers, $fields)
    {
        $idKey = $fields->getIdKeyField();
        $all = $fields->all();
        return $data->map(function ($field, $id) use ($headers, $all, $idKey) {
            $row = [];
            foreach ($headers as $key => $cell) {
                $row[$key] = $all[$key]->parseCell($field);
            }
            $row['model_row_id'] = $field[$idKey];
            return $row;
        });
    }
}
