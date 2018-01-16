<?php

namespace Beebmx\Panel;

use Illuminate\Support\Facades\Storage;

class PFiles
{
    protected $base;
    protected $blueprint;
    protected $id = false;
    protected $options;
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
        $this->options = $this->blueprint->files;
    }

    public function getSettings()
    {
        return $this->blueprint->files ?: false;
    }

    public function all()
    {
        $files = collect();
        if (Storage::disk(config('panel.disk'))->exists($this->path)) {
            foreach (Storage::disk(config('panel.disk'))->files($this->path) as $file) {
                if (basename($file) !== '.DS_Store') {
                    $files->push(new PFile($this, basename($file)));
                }
            }
            return $files;
        }
        return false;
    }

    public function images()
    {
        return $this->all()->filter(function ($file, $key) {
            return !!$file->isImage();
        });
    }

    public function documents()
    {
        return $this->all()->filter(function ($file, $key) {
            return !!$file->isDocument();
        });
    }

    public function image($file)
    {
        //find and check if its an image and return pfile
    }

    public function document($file)
    {
        //find and check if its an document and return pfile
    }

    // public function getByType($type)
    // {
    //     $types = collect();
    //     $files = $this->all();
    //     foreach ($files as $file) {
    //         if ($file->type() === $type) {
    //             $types->push($file);
    //         }
    //     }
    //     return $types;
    // }

    public function find($file)
    {
        //find file and return pfile
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
                PFile::delete($this->tmp(), $file['filename']);
            } elseif ($file['location'] === 'remote' && $file['status'] === 'deleted') {
                PFile::delete($this->path(), $file['filename'], true, $this->options());
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
            PFile::delete($this->tmp(), $file['filename']);
        }
        return true;
    }

    public function setId($id)
    {
        if ($id) {
            $this->id = $id;
            $this->path = $this->base . '/' . $this->id;
        }

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

    public function options()
    {
        return $this->options;
    }
}
