<?php

namespace Beebmx\Panel;

use File;
use Storage;
use Exception;
use Image;
use Illuminate\Support\Collection;

class FilePanel{    
    
    public $filename;
    private $filepath;
    protected $model;
    
    public static $types = [
        'image' => [
            'jpeg', 'jpg', 'jpe', 'gif', 'png', 'svg', 'ico', 'tif', 'tiff', 'bmp'
        ],
        'imagex' => [
            'psd', 'ai', 'eps', 'ps'
        ],
        'document' => [
            'txt', 'text', 'mdown', 'md', 'markdown', 'pdf', 'doc', 'docx', 'dotx', 'word', 'xl', 'xls', 'xlsx',
            'xltx', 'ppt', 'pptx', 'potx', 'csv', 'rtf', 'rtx', 'log', 'odt', 'odp', 'odc',
        ],
        'archive' => [
            'zip', 'tar', 'gz', 'gzip', 'tgz',
        ],
        'code' => [
            'js', 'css', 'scss', 'htm', 'html', 'shtml', 'xhtml', 'php', 'php3', 'php4',
            'rb', 'xml', 'json', 'java', 'py'
        ],
        'video' => [
            'mov', 'movie', 'avi', 'ogg', 'ogv', 'webm', 'flv', 'swf', 'mp4', 'm4v', 'mpg', 'mpe'
        ],
        'audio' => [
            'mp3', 'm4a', 'wav', 'aif', 'aiff', 'midi',
        ],
    ];
    
    public function __construct($model, $filename){
        $this->model = $model;
        $this->filename = $filename;
        $this->filepath = $this->directory().'/'.$this->filename;
        $this->filethumb = $this->thumbDirectory().'/'.$this->filename;
    }
    
    /**
     * Similar to $this->path but this is a dynamic function
     * uri function.
     * @access public
     * @return void
     */
    public function uri(){
        if ($this->model->getId()){
            return 'resources/'.$this->model->storage.'/'.$this->model->getId();
        }else{
            return FilePanel::tmpPath($this->model);
        }
    }
    
    public function url(){
        return Storage::disk(config('panel.disk'))->url($this->filepath);
    }
    
    public function thumb(){
        if (FilePanel::getType($this->basename()) === 'image') {
            return Storage::disk(config('panel.disk'))->url($this->filethumb);
        } else {
            return false;
        }
    }
    
    public function process($find = false){
        if (static::existsProcessMethod($this->model, $find)) {
            $name = static::getName($this->name());
            $extension = static::getExtension($this->name());
            $prefix = isset($this->files[$find]['prefix']) ? true : false;
            $file = $prefix ? $find.'_'.$name.'.'.$extension :
                              $name.'_'.$find.'.'.$extension;
            if (static::exists($this->processDirectory().'/'.$file)) {
                return Storage::disk(config('panel.disk'))->url($this->processDirectory().'/'.$file);
            }
            return false;
        } else {
            return false;
        }
    }
    
    public function get($filename){
        return Storage::disk(config('panel.disk'))->get($this->filepath);
    }
    
    public function directory(){
        if ($this->model->getId()){
            return 'resources/'.$this->model->storage.'/'.$this->model->getId();
        }
    }
    
    public function thumbDirectory(){
        if ($this->model->getId()){
            return 'resources/'.$this->model->storage.'/'.$this->model->getId().'/thumb';;
        }
    }
    
    public function processDirectory(){
        if ($this->model->getId()){
            return 'resources/'.$this->model->storage.'/'.$this->model->getId().'/process';;
        }
    }
    
    public function name(){
        return $this->basename();
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
    
    public function extension(){
        return static::getExtension($this->basename());
    }
    
    public function type(){
        $extension = strtolower($this->extension());
        foreach(static::$types as $type => $extensions) {
            if(in_array($extension, $extensions)) {
                return $type;
            }
        }
        return null;
    }
    
    public static function store($file, $model){
        $path = FilePanel::path($model);
        $uploaded = $file->storeAs($path, $file->getClientOriginalName(), config('panel.disk'));
        if (FilePanel::isImage($file->getClientOriginalName())){
            FilePanel::thumbImage($file, $model);
            if (FilePanel::hasProcess($model)){
                FilePanel::processImage($file, $model);
            }
        }
        return $uploaded;
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
    
    public static function tmpThumbPath($model){
        return 'resources/'.$model->storage.'/thumb';
    }
    
    public static function tmpProcessPath($model){
        return 'resources/'.$model->storage.'/process';
    }
    
    public static function path($model){
        if ($model->getId()){
            return 'resources/'.$model->storage.'/'.$model->getId();
        }else{
            return FilePanel::tmpPath($model);
        }
    }
    
    public static function thumbPath($model){
        if ($model->getId()){
            return 'resources/'.$model->storage.'/'.$model->getId().'/thumb';
        }else{
            return FilePanel::tmpThumbPath($model);
        }
    }
    
    public static function processPath($model){
        if ($model->getId()){
            return 'resources/'.$model->storage.'/'.$model->getId().'/process';
        }else{
            return FilePanel::tmpProcessPath($model);
        }
    }
    
    public static function getType($file){
        $extension = strtolower(static::getExtension($file));
        foreach(static::$types as $type => $extensions) {
            if(in_array($extension, $extensions)) {
                return $type;
            }
        }
        return null;
    }
    
    public static function isImage($file){
        return static::getType($file) === 'image' ? true : false;
    }
    
    public static function isVideo($file){
        return static::getType($file) === 'video' ? true : false;
    }
    
    public static function isDocument($file){
        return static::getType($file) === 'document' ? true : false;
    }
    
    public static function hasProcess($model){
        return is_array($model->files) ? true : false;
    }
    
    public static function thumbImage($file, $model){
        $path = FilePanel::thumbPath($model).'/'.$file->getClientOriginalName();
        $image = Image::make($file)
                      ->interlace()
                      ->fit(70, 70);
        Storage::disk(config('panel.disk'))->put($path, (string) $image->encode());
    }
    
    public static function existsProcessMethod($model, $find){
        if (static::hasProcess($model)){
            $files = $model->files;
            foreach($files as $key => $file){
                if (strtolower($find) === strtolower($key)){
                    return true;
                }
            }
            return false;
        } else {
            return false;
        }
    }
    
    public static function getProcessMethod($image, $method, $options){
        switch ($method){
            case 'fit': case 'resize':
                $size = isset($options['size']) ? $options['size'] : '200x200';
                $size = explode('x', $size);
                return $image->$method($size[0], isset($size[1]) ? $size[1] : null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            break;
            case 'blur': case 'brightness': case 'contrast': case 'gamma':
            case 'opacity': case 'pixelate': case 'rotate': case 'sharpen':
                $amount = isset($options['amount']) ? (int) $options['amount'] : 0;
                return $image->$method($amount);
            break;
            case 'flip':
                $mode = isset($options['mode']) ? $options['mode'] : 'h';
                return $image->$method($mode);
            break;
            case 'greyscale': case 'invert':
                return $image->$method();
            break;
            case 'watermark':
                $position = isset($options['position']) ? $options['position'] : 'bottom-right';
                $size = isset($options['size']) ? $options['size'] : '50x50';
                $x = isset($options['x']) ? $options['x'] : 0;
                $y = isset($options['y']) ? $options['y'] : 0;
                $size = explode('x', $size);
                
                $watermark = Image::make(public_path($options['url']));
                $watermark->resize($size[0], isset($size[1]) ? $size[1] : null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                return $image->insert($watermark, $position, $x, $y);
            break;
        }
    }
    
    public static function processImage($file, $model){
        $toProcess = $model->files;
        foreach ($toProcess as $key => $process){
            $prefix = isset($process['prefix']) ? true : false;
            $methods = isset($process['method']) ? $process['method'] : [];
            $name = static::getName($file->getClientOriginalName());
            $extension = static::getExtension($file->getClientOriginalName());
            $path = $prefix ? FilePanel::processPath($model).'/'.$key.'_'.$name.'.'.$extension :
                              FilePanel::processPath($model).'/'.$name.'_'.$key.'.'.$extension;
            
            $image = Image::make($file)
                          ->interlace();
            
            foreach($methods as $method => $options){
                $image = FilePanel::getProcessMethod($image, $method, $options);
            }
            Storage::disk(config('panel.disk'))->put($path, (string) $image->encode());
        }
    }
    
    public static function moveProcess($model, $filename){
        $path = FilePanel::processPath($model);
        $tmp = FilePanel::tmpProcessPath($model);
        $name = static::getName($filename);
        $extension = static::getExtension($filename);
        $toProcess = $model->files;
        foreach ($toProcess as $key => $process){
            $prefix = isset($process['prefix']) ? true : false;
            $file = $prefix ? $key.'_'.$name.'.'.$extension :
                              $name.'_'.$key.'.'.$extension;
            static::move($tmp.'/'.$file, $path.'/'.$file);
        }
    }
    
    public static function deleteProcess($model, $filename){
        $path = FilePanel::processPath($model);
        $tmp = FilePanel::tmpProcessPath($model);
        $name = static::getName($filename);
        $extension = static::getExtension($filename);
        $toProcess = $model->files;
        foreach ($toProcess as $key => $process){
            $prefix = isset($process['prefix']) ? true : false;
            $file = $prefix ? $key.'_'.$name.'.'.$extension :
                              $name.'_'.$key.'.'.$extension;
            static::delete($path.'/'.$file);
        }
    }
    
    public static function getName($filename){
        return pathinfo($filename, PATHINFO_FILENAME);
    }
    
    public static function getExtension($filename){
        return pathinfo($filename, PATHINFO_EXTENSION);
    }
    
}