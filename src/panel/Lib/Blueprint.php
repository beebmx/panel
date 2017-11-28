<?php

namespace Beebmx\Panel;

use File;
use Lang;
use Exception;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Collection;
use Beebmx\Panel\Fields;
use Beebmx\Panel\Features\HasSettings;

class Blueprint
{   
    use HasSettings;

    protected $id = false;
    protected $filename;
    protected $class;
    protected $file;
    
    public function __construct($file)
    {
        $this->filename = File::name($file);
        $this->file = Yaml::parse(File::get($file));
        $this->class = isset($this->file['class']) ? $this->file['class'] : false;
        
        foreach ($this->file as $setting => $value) {
            $this->setSetting($setting, $value);
        }

        $this->setDefaults();
    }

    protected function getDefaults()
    {
        return ['name'    => ucfirst($this->filename),
                'admin'   => false,
                'type'    =>'model',
                'icon'    => 'list',
                'options' => [],
                'order'   => [],
        ];
    }

    public function getFields()
    {
        return new Fields($this->fields);
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this->id;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        return route('panel.' . $this->type . '.index', ['model' => $this->filename]);
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function data()
    {
        return new BlueprintData($this);
    }

    public static function exists($model)
    {
        return File::exists(static::path($model));
    }

    public static function path($file)
    {
        return app_path('Panel/Blueprints/'.$file.'.yml');
    }

    public static function getAllModels($admin = false)
    {
        $files = File::files(app_path('Panel/Blueprints'));
        $models = [];
        foreach ($files as $file) {
            $model = new Blueprint($file);
            if ($model->admin && $admin) {
                $models[] = $model;
            }else if (!$model->admin) {
                $models[] = $model;
            }
        }
        return $models;
    }

    public static function getListModels($admin = false)
    {
        $all = static::getAllModels($admin);
        $models = collect();
        foreach ($all as $model) {
            $models->push(['blueprint' => $model->filename,
                           'name'      => $model->name,
                           'type'      => $model->type,
                           //'admin'    => $model->admin,
                           'icon'      => $model->icon,
                           //'url'      => $model->getUrl()
                           
                          ]);
        }
        
        if (config('panel.sidebarOrder')) {
            return $models->groupBy('type')->sortBy('sidebarOrder')->toArray();
        } else {
            return $models->groupBy('type')->sortBy('name')->toArray();
        }
    }
}