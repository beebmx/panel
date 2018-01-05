<?php

namespace Beebmx\Panel;

use Illuminate\Support\Facades\Storage;

class PFile
{
    protected $files;
    protected $file;
    protected $pathfile;
    public $basename;
    public $filename;
    public $size = 0;
    public $type;
    public $mime;
    public $extension;

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
            static::delete($pfile);
        }
        Storage::disk(config('panel.disk'))->move($this->files->tmp() . '/' . $file, $pfile);
        $this->isStored();

        return $this;
    }

    public function getExtension()
    {
        return pathinfo($this->file, PATHINFO_EXTENSION);
    }

    public function getSize()
    {
        if ($this->size >= 1000000000) {
            return round($this->size / 1000000000, 2) . ' GB';
        }
        if ($this->size >= 1000000) {
            return round($this->size / 1000000, 2) . ' MB';
        }
        return round($this->size / 1000, 2) . ' KB';
    }

    public function rawSize()
    {
        return Storage::disk(config('panel.disk'))->size($this->pathfile);
    }

    public function getMime()
    {
        return Storage::disk(config('panel.disk'))->mimeType($this->pathfile);
    }

    public function getType()
    {
        foreach (static::$types as $type => $extensions) {
            if (in_array($this->extension, $extensions)) {
                return $type;
            }
        }
        return null;
    }

    public function url()
    {
        return Storage::disk(config('panel.disk'))->url($this->pathfile);
    }

    public static function exists($file)
    {
        return Storage::disk(config('panel.disk'))->exists($file);
    }

    public static function delete($file)
    {
        Storage::disk(config('panel.disk'))->delete($file);
    }

    protected function isStored()
    {
        $this->extension = $this->getExtension();
        $this->basename = str_slug(basename($this->file, '.' . $this->extension));
        $this->filename = $this->basename . '.' . $this->extension;
        $this->pathfile = $this->files->path() . '/' . $this->filename;
        $this->size = $this->rawSize();
        $this->mime = $this->getMime();
        $this->type = $this->getType();
    }

    protected function isUpload()
    {
        $this->extension = $this->file->getClientOriginalExtension();
        $this->basename = str_slug(basename($this->file->getClientOriginalName(), '.' . $this->extension));
        $this->filename = $this->basename . '.' . $this->extension;
        $this->pathfile = $this->files->path() . '/' . $this->filename;
        $this->size = $this->file->getClientSize();
        $this->mime = $this->file->getMimeType();
        $this->type = $this->getType();
    }
}
