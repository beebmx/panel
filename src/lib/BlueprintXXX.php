<?php

namespace Beebmx\Panel;

use File;
use Lang;
use Exception;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Collection;
use Beebmx\Panel\FilesPanel;

class BlueprintXXX{
    private $model;
    public $name;
    private $class;
    public $admin;
    public $storage;
    public $icon;
    public $sidebarOrder;
    public $paginate;
    private $search;
    private $orderBy;
    private $sort;
    public $url;
    public $fields;
    public $files;
    public $maxFileSize;
    private $id;
    
    public $create;
    public $update;
    public $delete;
    
    public $children;
        
    public function __construct($file){
        
        $this->model = Yaml::parse(File::get($file));
        $this->class = isset($this->model['class']) ? $this->model['class'] : false;
        $this->type = isset($this->model['type']) ? $this->model['type'] : 'crud';
        $this->name = $this->model['name'];
        $this->admin = isset($this->model['admin']) ? $this->model['admin'] : false;
        $this->storage = isset($this->model['storage']) ? $this->model['storage'] : '';
        $this->icon = isset($this->model['icon']) ? $this->model['icon'] : '<i class="fa fa-fw fa-list"></i>';
        $this->sidebarOrder = isset($this->model['sidebarOrder']) ? $this->model['sidebarOrder'] : 0;
        $this->paginate = isset($this->model['paginate']) ? $this->model['paginate'] : config('panel.paginate');
        $this->search = isset($this->model['search']) ? $this->model['search'] : 'name';
        $this->orderBy = isset($this->model['orderBy']) ? $this->model['orderBy'] : 'id';
        $this->sort = isset($this->model['sort']) ? $this->model['sort'] : 'asc';
        
        switch ($this->type){
            case 'external':
                $this->url = url($this->model['url']);
            break;
            default:
                //$this->url = url(config('panel.prefix').'/page/'.File::name($file));
                $this->url = File::name($file);
        }
        $this->fields = isset($this->model['fields']) ? $this->model['fields'] : false;
        
        $this->files = isset($this->model['files']) ? $this->model['files'] : false;
        $this->maxFileSize = isset($this->model['maxFileSize']) ? $this->model['maxFileSize'] : 10;
        
        $this->id = false;
        
        $this->create = isset($this->model['create']) ? $this->model['create'] : true;
        $this->update = isset($this->model['update']) ? $this->model['update'] : true;
        $this->delete = isset($this->model['delete']) ? $this->model['delete'] : true;
        
        $this->children = isset($this->model['children']) ? $this->model['children'] : false;
    }
    
    public function find($id){
        $this->setId($id);
        $model = $this->class;
        return $model::find($id);
    }
    
    public function all($request = false){
        $q = $request->has('q') ? $request->input('q') : false;
        $model = $this->class;
        if (!$q) {
            return $model::orderBy($this->orderBy, $this->sort)->paginate($this->paginate);
        }else {
            $search = $this->getAllSearchableFields($q);
            $wmodel = $model::orderBy($this->orderBy, $this->sort);
            $first = false;
            foreach($search as $w){
                if (!$first){
                    $first = true;
                    $wmodel->where($w[0], $w[1], $w[2]);
                }else{
                    $wmodel->orWhere($w[0], $w[1], $w[2]);
                }
            }
            return $wmodel->paginate($this->paginate);
        }
    }
    
    public function allForeign($request = false, $record){
        $q = $request->has('q') ? $request->input('q') : false;
        $model = $this->class;
        if (!$q) {
            return $model::where($this->getForeign(), $record)->orderBy($this->orderBy, $this->sort)->paginate($this->paginate);
        }else {
            $search = $this->getAllSearchableFields($q);
            $wmodel = $model::where($this->getForeign(), $record)->orderBy($this->orderBy, $this->sort);
            $wmodel->where(function ($query) use ($search) {
                $first = false;
                foreach($search as $w){
                    if (!$first){
                        $first = true;
                        $query->where($w[0], $w[1], $w[2]);
                    }else{
                        $query->orWhere($w[0], $w[1], $w[2]);
                    }
                }
            });
            return $wmodel->paginate($this->paginate);
        }
    }
    
    public function getAllSearchableFields($q){
        $search = [];
        if(is_array($this->search)) {
            $search = [];
            foreach($this->search as $field => $option){
                if ($option !== null) {
                    $search[] = [$field, $option, $q];
                } else {
                    $search[] = [$field, 'LIKE', '%'.$q.'%'];
                }
            }
        }else{
            $search[] = [$this->search, 'LIKE', '%'.$q.'%'];
        }
        return $search;
    }
    
    public function insert($fields){
        $model = $this->class;
        $record = new $model;
        foreach($fields as $field => $data){
            $classField = $this->getClassField(strtolower($this->getFieldType($field)));
            $record->$field = $classField::store($data, $this->getField($field));
        }
        $record->save();
        $id = $this->getIdField();
        $this->setId($record->$id);
        return $record->$id;
    }
    
    public function update($fields){
        $model = $this->class;
        $record = $this->find($this->getId());
        foreach($fields as $field => $data){
            $classField = $this->getClassField(strtolower($this->getFieldType($field)));
            if ($classField::$updateEmpty || !empty($data)){
                $record->$field = $classField::store($data, $this->getField($field));
            }
        }
        $record->save();
        return $record;
    }
    
    public function delete(){
        $model = $this->class;
        $record = $this->find($this->getId());
        $record->delete();
        return $record;
    }
    
    public static function getAllModels($admin = false){
        $files = File::files(app_path('Panel/Blueprints'));
        $list = [];
        foreach ($files as $file) {
            $model = new Blueprint($file);
            if ($model->admin && $admin){
                $list[] = $model;
            }else if (!$model->admin){
                $list[] = $model;
            }
        }
        return $list;
    }
    
    public function getIdField(){
        $id = null;
        foreach($this->fields as $field => $data){
            if (strtolower($data['type']) === 'id'){
                $id = $data['type'];
            }
	    }
	    return $id;
    }
    
    public function getListHeaders(){
        $fields = [];
        foreach($this->fields as $field => $data){
		    if (isset($data['list']) ? $data['list'] : true){
			    $fields[] = $field;
		    }
	    }
	    return $fields;
    }
    
    public function only(){
        $fields = [];
        foreach($this->fields as $field => $data){
            $classField = $this->getClassField(strtolower($data['type']));
            if ($classField::$stored){
		        $fields[] = $field;
		    }
	    }
	    return $fields;
    }
    
    public function getForeign(){
        $foreign = false;
        foreach($this->fields as $field => $data){
            if (strtolower($data['type']) === 'foreign'){
                $foreign = $field;
            }
	    }
	    return $foreign;
    }
    
    public function getValidations($input){
        $validation = [];
        foreach($this->fields as $field => $data){
            $classField = $this->getClassField(strtolower($data['type']));
            if ($classField::$stored){
                $current = new $classField($field, $this->fields[$field]);
                $current->value = $input[$field];
                //if ($this->getId()){
    		        $validation[$field] = $current->validate($this->getId(), $this->getIdField());
    		    //}
		    }
	    }
        return $validation;
    }
    
    public function supportFiles(){
        if ($this->files){
            return true;
        }else{
            return false;
        }
    }
    
    public function getPathFiles(){
        if ($this->getId()){
            return 'resources/'.$this->storage.'/'.$this->getId();
        }else{
            return false;
        }
    }
    
    public function files(){
        //$files = new FilesPanel($this);
        return new FilesPanel($this);
    }
    
    public function setId($id){
        $this->id = $id;
        return $this->id;
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function isChildren(){
        return $this->children;
    }
    
    public static function path($model){
        return app_path('Panel/Blueprints/'.$model.'.yml');
    }
    
    public static function exists($model){
        return File::exists(Blueprint::path($model));
    }
    
    private function getField($field){
        return $this->fields[$field];
    }
    
    private function getFieldType($field){
        return $this->fields[$field]['type'];
    }
    
    private function getFullNamespace($filename) {
        $lines = file($filename);
        $regx = preg_grep('/^namespace /', $lines);
        $namespaceLine = array_shift($regx);
        $match = array();
        preg_match('/^namespace (.*);$/', $namespaceLine, $match);
        $fullNamespace = array_pop($match);
        return $fullNamespace;
    }
    
    private function getClassField($type){
        $type = ucwords($type);
        if (class_exists('Beebmx\\Panel\\Fields\\' . $type . 'Field')){
            return 'Beebmx\\Panel\\Fields\\' . $type . 'Field';
        }else{
            $filename = app_path('Panel/Fields/'.$type.'/'.$type.'.php');
            return $this->getFullNamespace($filename).'\\' . $type . 'Field';
        }
    }
}