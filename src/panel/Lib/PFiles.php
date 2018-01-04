<?php

namespace Beebmx\Panel;

use Illuminate\Support\Facades\Storage;

class PFiles
{
    protected $base;
    protected $blueprint;
    protected $id = false;
    protected $path;
    protected $storage;
    protected $tmp;

    public function __construct($blueprint)
    {
        $this->blueprint = $blueprint;
        $this->storage = isset($this->blueprint->options['storage'])
                            ? $this->blueprint->options['storage']
                            : str_singular($this->blueprint->getFilename());
        $this->base = $this->blueprint->type . '/' . $this->storage;
        $this->tmp = $this->base . '/tmp';
        $this->path = $this->tmp;
    }

    public function getSettings()
    {
        return $this->blueprint->files ?: false;
    }

    public function all()
    {
        $files = [];
        if (Storage::disk(config('panel.disk'))->exists($this->path)) {
            foreach (Storage::disk(config('panel.disk'))->files($this->path) as $file) {
                if (basename($file) !== '.DS_Store') {
                    $files[] = new PFile($this, basename($file));
                }
            }
            return $files;
        }
        return false;
    }

    public function find($id)
    {
    }

    public function save($id = false)
    {
        //Validate files
        $files = request()->file('files');
        $uploaded = [];
        if ($id) {
            $this->setId($id);
        }
        foreach ($files as $file) {
            $uploaded[] = tap(new PFile($this, $file))->save();
        }
        return $uploaded;
    }

    public function process()
    {
        //Validate json structure
        $files = collect(request()->input('files'))->filter(function ($file, $key) {
            return $file['status'] !== 'remote';
        });
        foreach ($files as $file) {
            if ($file['status'] === 'pending') {
                tap(new PFile($this))->move($file['filename']);
            } elseif ($file['location'] === 'tmp' && $file['status'] === 'deleted') {
                PFile::delete($this->tmp() . '/' . $file['filename']);
            } elseif ($file['location'] === 'remote' && $file['status'] === 'deleted') {
                PFile::delete($this->path() . '/' . $file['filename']);
            }
        }
        return $this->all();
    }

    public function reverse()
    {
        $files = collect(request()->input('files'))->filter(function ($file, $key) {
            return $file['location'] !== 'remote';
        });
        foreach ($files as $file) {
            PFile::delete($this->tmp() . '/' . $file['filename']);
        }
        return true;
    }

    public function setId($id)
    {
        $this->id = $id;
        $this->path = $this->base . '/' . $this->id;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getBase()
    {
        return $this->base;
    }

    public function path()
    {
        return $this->path;
    }

    public function tmp()
    {
        return $this->tmp;
    }
}
