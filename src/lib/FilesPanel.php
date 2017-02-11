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
    
    public static function process($files, $model, $isNew = false){
        $path = FilePanel::path($model);
        $tmp = FilePanel::tmpPath($model);
        foreach($files as $file){
            switch($file['action']){
                case 'add':
                    if ($isNew){
                        FilePanel::move($tmp.'/'.$file['file'], $path.'/'.$file['file']);
                    }
                break;
                case 'delete':
                    FilePanel::delete($path.'/'.$file['file']);
                break;
            }
        }
    }
    
    public static function all($model){
        $files = collect();
        $path = FilePanel::path($model);
        if (Storage::disk(config('panel.disk'))->exists($path)){
            foreach (Storage::disk(config('panel.disk'))->files($path) as $f){
                $file = new FilePanel($model, basename($f));
                $files->push($file);
            }
            return $files;
        }else{
            return false;
        }
    }
}