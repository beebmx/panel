<?php

namespace Beebmx\Panel;

use File;
use Lang;
use Exception;
use Illuminate\Support\Collection;
use Beebmx\Panel\FilesPanel;

class ModelXXX{
    private $class;
    private $id;
        
    public function __construct($model){
        $this->class = $model;
        $this->id = false;
    }
    
    public function all(){
        $model = $this->class;
        return $model::all();
    }
    
    public function find($id, $value){
        $model = $this->class;
        return $model::where($id, $value)->first();
    }
    
    public static function exists($class){
        return class_exists($class);
    }
}