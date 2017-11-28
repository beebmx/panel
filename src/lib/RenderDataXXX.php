<?php

namespace Beebmx\Panel;

use File;
use Lang;
use Exception;
use Illuminate\Support\Collection;

class RenderDataXXX{
    protected $model;
    protected $record;
    protected $errors;
    
    public function __construct($model, $record = null, $errors = null){
        $this->model = $model;
        $this->record = $record;
        $this->errors = $errors;
    }
    
    public function index(){
        $records = collect();
        $fields = $this->model->getListHeaders();
        foreach($this->record as $record){
            $data = collect();
            foreach($fields as $id){
                $classField = $this->getClassField($this->model->fields[$id]['type']);
                $current = new $classField($id, $this->model->fields[$id]);
                if ($classField::$recordable){
                    $current->value = $record[$id];
                }else{
                    $current->value = $record;
                }
                $data->put($id, $current->cell());
            }
            $records->push($data);
        }
        return $records;
    }
    
    public function form(){
        $fields = collect();
        foreach($this->model->fields as $id => $field){
            $classField = $this->getClassField($this->model->fields[$id]['type']);
            if ($classField::$stored){
                if ($this->errors !== null){
                    $error = count($this->errors->get($id)) ? $this->errors->get($id) : false;
                }else{
                    $error = false;
                }
                $current = new $classField($id, $this->model->fields[$id], $error);
                if ($this->record !== null){
                    $current->value = $this->record[$id];
                }
                $template = $current->template();
                if ($template) {
                    $fields->put($id, $current->template());
                }
            }
        }
        return $fields;
    }
    
    public function view(){
        $fields = collect();
        foreach($this->model->fields as $id => $field){
            $classField = $this->getClassField($this->model->fields[$id]['type']);
            if ($classField::$stored){
                if ($this->errors !== null){
                    $error = count($this->errors->get($id)) ? $this->errors->get($id) : false;
                }else{
                    $error = false;
                }
                $current = new $classField($id, $this->model->fields[$id], $error);
                if ($this->record !== null){
                    $current->value = $this->record[$id];
                }
                if ($current->show()) {
                    $fields->put($id, $current->show());
                }
            }
        }
        return $fields;
    }
    
    public function modal(){
        $modals = collect();
        foreach($this->model->fields as $id => $field){
            $classField = $this->getClassField($this->model->fields[$id]['type']);
            $current = new $classField($id, $this->model->fields[$id], false);
            if ($current->modal()) {
                $modals->put($id, $current->modal());
            }
        }
        return $modals;
    }
    
    public function css(){
        $resource = [];
        foreach($this->model->fields as $id => $field){
            $classField = $this->getClassField($this->model->fields[$id]['type']);
            $current = new $classField($id, $this->model->fields[$id], false);
            if (count($current->css())) {
                foreach($current->css() as $file){
                    $resource[] = $file;
                }
            }
        }
        return $resource;
    }
    
    public function js(){
        $resource = [];
        foreach($this->model->fields as $id => $field){
            $classField = $this->getClassField($this->model->fields[$id]['type']);
            $current = new $classField($id, $this->model->fields[$id], false);
            if (count($current->js())) {
                foreach($current->js() as $file){
                    $resource[] = $file;
                }
            }
        }
        return $resource;
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