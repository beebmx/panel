<?php

namespace Beebmx\Panel;

use File;
use Storage;
use Exception;
use Illuminate\Support\Collection;

class FilePanel{    
    
    public $filename;
    private $filepath;
    protected $model;
    public function __construct($model, $filename){
        $this->model = $model;
        $this->filename = $filename;
        $this->filepath = $this->directory().'/'.$this->filename;
    }
    
    public function url(){
        return Storage::disk(config('panel.disk'))->url($this->filepath);
    }
    
    public function get($filename){
        return Storage::disk(config('panel.disk'))->get($this->filepath);
    }
    
    public function directory(){
        if ($this->model->getId()){
            return 'resources/'.$this->model->storage.'/'.$this->model->getId();
        }
    }
    
    public function basename(){
        return $this->filename;
    }
    
    public function rawSize(){
        return Storage::disk(config('panel.disk'))->size($this->filepath);
    }
    
    public function size(){
        $size = $this->rawSize();
        if ($size >= 1000000000) {
            return round($size / 1000000000, 2) . ' GB';
        }
        if ($size >= 1000000) {
            return round($size / 1000000, 2) . ' MB';
        }
        return round($size / 1000, 2) . ' KB';
    }
    
    public function mime(){
        return Storage::disk(config('panel.disk'))->mimeType($this->filepath);
    }
    
    public static function store($file, $model){
        $path = FilePanel::path($model);
        $file = $file->storeAs($path, $file->getClientOriginalName(), config('panel.disk'));
        return $file;
    }
    
    public static function move($source, $destination){
        if (FilePanel::exists($source)){
            Storage::disk(config('panel.disk'))->move($source, $destination);
        }
    }
    
    public static function delete($file){
        if (FilePanel::exists($file)){
            Storage::disk(config('panel.disk'))->delete($file);
        }
    }
    
    public static function exists($file){
        return Storage::disk(config('panel.disk'))->exists($file);
    }
    
    public static function tmpPath($model){
        return 'resources/'.$model->storage.'/0';
    }
    
    public static function path($model){
        if ($model->getId()){
            return 'resources/'.$model->storage.'/'.$model->getId();
        }else{
            return 'resources/'.$model->storage.'/0';
        }
    }
}