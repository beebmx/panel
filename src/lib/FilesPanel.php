<?php

namespace Beebmx\Panel;

use File;
use Storage;
use Exception;
use Illuminate\Support\Collection;
use Beebmx\Panel\FilePanel;

class FilesPanel{
    protected $model;
    public function __construct($model){
        $this->model = $model;
    }
    
    public function all(){
        $files = collect();
        $path = FilePanel::path($this->model);
        if (Storage::disk(config('panel.disk'))->exists($path)){
            foreach (Storage::disk(config('panel.disk'))->files($path) as $f){
                if (basename($f) !== '.DS_Store'){
                    $file = new FilePanel($this->model, basename($f));
                    $files->push($file);
                }
            }
            return $files;
        }else{
            return false;
        }
    }
    
    public function getByType($type){
        $types = collect();
        $files = $this->all();
        foreach($files as $file){
            if ($file->type() === $type){
                $types->push($file);
            }
        }
        return $types;
    }
    
    public function images()    { return $this->getByType('image');    }
    public function imagesx()   { return $this->getByType('imagex');   }
    public function videos()    { return $this->getByType('video');    }
    public function documents() { return $this->getByType('document'); }
    public function audio()     { return $this->getByType('audio');    }
    public function code()      { return $this->getByType('code');     }
    public function archives()  { return $this->getByType('archive');  }
    
    public static function process($files, $model, $isNew = false){
        $path = FilePanel::path($model);
        $tmp = FilePanel::tmpPath($model);
        $tpath = FilePanel::thumbPath($model);
        $thumb = FilePanel::tmpThumbPath($model);
        foreach($files as $file){
            switch($file['action']){
                case 'add':
                    if ($isNew){
                        FilePanel::move($tmp.'/'.$file['file'], $path.'/'.$file['file']);
                        if (FilePanel::isImage($thumb.'/'.$file['file'])){
                            FilePanel::move($thumb.'/'.$file['file'], $tpath.'/'.$file['file']);
                            if (FilePanel::hasProcess($model)){
                                FilePanel::moveProcess($model, $file['file']);
                            }
                        }
                    }
                break;
                case 'delete':
                    FilePanel::delete($path.'/'.$file['file']);
                    if (FilePanel::isImage($tpath.'/'.$file['file'])){
                        FilePanel::delete($tpath.'/'.$file['file']);
                        if (FilePanel::hasProcess($model)){
                            FilePanel::deleteProcess($model, $file['file']);
                        }
                    }
                break;
            }
        }
    }
    
    public static function get($model){
        $files = collect();
        $path = FilePanel::path($model);
        if (Storage::disk(config('panel.disk'))->exists($path)){
            foreach (Storage::disk(config('panel.disk'))->files($path) as $f){
                if (basename($f) !== '.DS_Store'){
                    $file = new FilePanel($model, basename($f));
                    $files->push($file);
                }
            }
            return $files;
        }else{
            return false;
        }
    }
}