<?php

namespace Beebmx\Panel;

use File;
use Lang;
use Exception;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Collection;
use Beebmx\Panel\FilesPanel;

class Blueprint{
    private $model;
    public $name;
    private $class;
    public $admin;
    public $storage;
    public $icon;
    public $sidebarOrder;
    public $paginate;
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
        $this->icon = isset($this->model['icon']) ? $this->model['icon'] : 'ti-view-list';
        $this->sidebarOrder = isset($this->model['sidebarOrder']) ? $this->model['sidebarOrder'] : 0;
        $this->paginate = isset($this->model['paginate']) ? $this->model['paginate'] : config('panel.paginate');
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
        /*
        if ($this->class) {
            //$this->url = File::name($file);
            $this->url = url(config('panel.prefix').'/page/'.File::name($file));
        }else {
            $this->url = url($this->model['url']);
        }
        */
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
    
    public function all(){
        $model = $this->class;
        return $model::orderBy($this->orderBy, $this->sort)->paginate($this->paginate);
    }
    
    public function allForeign($record){
        $model = $this->class;
        return $model::where($this->getForeign(), $record)->orderBy($this->orderBy, $this->sort)->paginate($this->paginate);
    }
    
    public function insert($fields){
        $model = $this->class;
        $record = new $model;
        foreach($fields as $field => $data){
            $classField = $this->getClassField(strtolower($this->getFieldType($field)));
            $record->$field = $classField::store($data);
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
                $record->$field = $classField::store($data);
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
    
    private function getFieldType($field){
        return $this->fields[$field]['type'];
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