<?php

namespace Beebmx\Panel;

use Illuminate\Support\Facades\Storage;
use Image;

class PFile
{
    protected $files;
    protected $file;
    protected $pathfile;
    protected $basename;
    protected $filename;
    protected $size = 0;
    protected $type;
    protected $mime;
    protected $extension;

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

    public function __construct($files, $file = false)
    {
        $this->files = $files;
        if ($file) {
            $this->file = $file;
            if (is_string($file)) {
                $this->isStored();
            } else {
                $this->isUpload();
            }
        }
    }

    public function save()
    {
        $this->file->storeAs($this->files->path(), $this->filename, config('panel.disk'));
        return $this;
    }

    public function get()
    {
        return Storage::disk(config('panel.disk'))->get($this->pathfile);
    }

    public function move($file)
    {
        $this->file = $file;
        $pfile = $this->files->path() . '/' . $file;
        if (static::exists($pfile)) {
            static::delete($this->files->path(), $file);
        }
        Storage::disk(config('panel.disk'))->move($this->files->tmp() . '/' . $file, $pfile);

        $this->isStored();
        $this->process();

        return $this;
    }

    public function rawSize()
    {
        return Storage::disk(config('panel.disk'))->size($this->pathfile);
    }

    public function mime()
    {
        return Storage::disk(config('panel.disk'))->mimeType($this->pathfile);
    }

    public function size()
    {
        if ($this->size >= 1000000000) {
            return round($this->size / 1000000000, 2) . ' GB';
        }
        if ($this->size >= 1000000) {
            return round($this->size / 1000000, 2) . ' MB';
        }
        return round($this->size / 1000, 2) . ' KB';
    }

    public function url()
    {
        return Storage::disk(config('panel.disk'))->url($this->pathfile);
    }

    public function filename()
    {
        return $this->filename;
    }

    public function basename()
    {
        return $this->basename;
    }

    public function extension()
    {
        return $this->extension;
    }

    public function type()
    {
        foreach (static::$types as $type => $extensions) {
            if (in_array($this->extension, $extensions)) {
                return $type;
            }
        }
        return null;
    }

    public function isImage()
    {
        return static::getType($this->extension) === 'image';
    }

    public function isDocument()
    {
        return static::getType($this->extension) === 'document';
    }

    public function isVideo()
    {
        return static::getType($this->extension) === 'video';
    }

    public function isAudio()
    {
        return static::getType($this->extension) === 'audio';
    }

    public function isArchive()
    {
        return static::getType($this->extension) === 'archive';
    }

    public function isCode()
    {
        return static::getType($this->extension) === 'code';
    }

    public function thumb()
    {
        if ($this->isImage()) {
            $this->pathfile = $this->files->path() . '/thumb/' . $this->filename;
        }
        return $this;
    }

    public function processed($method)
    {
        if ($this->isImage()) {
            $toProcess = $this->files->options();
            $process = $toProcess['images'][$method];
            $filename = static::getImageProcessFilename($method, $this->basename, $this->extension, $process);
            $this->pathfile = $this->files->path() . '/process/' . $filename;
        }
        return $this;
    }

    public function hasOptions()
    {
        return is_array($this->files->options()) ? true : false;
    }

    protected function isStored()
    {
        $this->extension = static::getExtension($this->file);
        $this->basename = str_slug(basename($this->file, '.' . $this->extension));
        $this->filename = $this->basename . '.' . $this->extension;
        $this->pathfile = $this->files->path() . '/' . $this->filename;
        $this->size = $this->rawSize();
        $this->mime = $this->mime();
        $this->type = static::getType($this->extension);
    }

    protected function isUpload()
    {
        $this->extension = $this->file->getClientOriginalExtension();
        $this->basename = str_slug(basename($this->file->getClientOriginalName(), '.' . $this->extension));
        $this->filename = $this->basename . '.' . $this->extension;
        $this->pathfile = $this->files->path() . '/' . $this->filename;
        $this->size = $this->file->getClientSize();
        $this->mime = $this->file->getMimeType();
        $this->type = static::getType($this->extension);
    }

    protected function process()
    {
        if ($this->isImage()) {
            $file = $this->get();
            $this->makeThumbnail($file);
            if ($this->hasOptions()) {
                $this->processImage($file);
            }
        }
        return $this;
    }

    protected function makeThumbnail($file)
    {
        $image = Image::make($file)
                      ->interlace()
                      ->fit(70, 70);
        Storage::disk(config('panel.disk'))
               ->put($this->files->path() . '/thumb/' . $this->filename, (string) $image->encode());

        return $this;
    }

    protected function processImage($file)
    {
        $toProcess = $this->files->options();
        $path = $this->files->path() . '/process/';
        foreach ($toProcess['images'] as $name => $process) {
            $methods = isset($process['methods']) ? $process['methods'] : [];
            $filename = static::getImageProcessFilename($name, $this->basename, $this->extension, $process);

            $image = Image::make($file)->interlace();

            foreach ($methods as $method => $options) {
                $this->processImageMethod($image, $method, $options);
            }
            if (static::exists($path . $filename)) {
                static::delete($path, $filename);
            }
            Storage::disk(config('panel.disk'))->put($path . $filename, (string) $image->encode());
        }
    }

    protected function processImageMethod($image, $method, $options)
    {
        switch ($method) {
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

    public static function exists($file)
    {
        return Storage::disk(config('panel.disk'))->exists($file);
    }

    public static function getExtension($file)
    {
        return pathinfo($file, PATHINFO_EXTENSION);
    }

    public static function getType($extension)
    {
        foreach (static::$types as $type => $extensions) {
            if (in_array($extension, $extensions)) {
                return $type;
            }
        }
        return null;
    }

    public static function delete($path, $file, $dependencies = false, $options = false)
    {
        Storage::disk(config('panel.disk'))->delete($path . '/' . $file);
        if ($dependencies) {
            static::deleteDependencies($path, $file, $options);
        }
    }

    public static function deleteDependencies($path, $file, $options)
    {
        if (static::getType(static::getExtension($file)) === 'image') {
            static::deleteImages($path, $file, $options['images']);
        }
    }

    public static function deleteImages($path, $file, $options)
    {
        if (static::exists($path . '/thumb/' . $file)) {
            Storage::disk(config('panel.disk'))->delete($path . '/thumb/' . $file);

            $filename = pathinfo($file, PATHINFO_FILENAME);
            $extension = static::getExtension($file);
            foreach ($options as $name => $process) {
                $process = static::getImageProcessFilename($name, $filename, $extension, $process);

                Storage::disk(config('panel.disk'))->delete($path . '/process/' . $process);
            }
        }
    }

    public static function getImageProcessFilename($name, $filename, $extension, $process = false)
    {
        $prefix = isset($process['prefix']) ? $process['prefix'] : false;
        return $prefix ? $name . '_' . $filename . '.' . $extension :
                         $filename . '_' . $name . '.' . $extension;
    }
}
