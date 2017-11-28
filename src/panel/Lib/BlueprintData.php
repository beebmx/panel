<?php

namespace Beebmx\Panel;

use File;
use Lang;
use Exception;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Collection;

class BlueprintData
{
    protected $blueprint;
    protected $id = false;
    protected $class;
    
    public function __construct($blueprint)
    {
        $this->blueprint = $blueprint;
        $this->class = $this->blueprint->getClass();
        $options = [
            'storage'  => str_singular($this->blueprint->getFilename()),
            'paginate' => config('panel.paginate'),
            'create'   => true,
            'update'   => true,
            'delete'   => true
        ];
        $order = [
            'field' => 'id',
            'sort'  => 'asc'
        ];

        $this->options = array_merge($options, $blueprint->options);
        $this->order = array_merge($order, $blueprint->order);
    }

    public function all()
    {
        $relationships = $this->getRelationships();
        $q = request()->has('q') ?: false;
        if (! $q) {
            if (count($relationships)) {
                return $this->class::with($relationships)
                                ->orderBy($this->order['field'], $this->order['sort'])
                                ->paginate($this->options['paginate']);
            } else {
                return $this->class::orderBy($this->order['field'], $this->order['sort'])
                                ->paginate($this->options['paginate']);
            }
        }
    }

    public function getHeaders()
    {
        return collect($this->blueprint->getFields()->all())->filter(function($field, $id) {
            return $field->list;
        })->map(function ($field, $id) {
            return collect($field->attributes)->only('id', 'label', 'cell', 'mobile', 'parent');
        });
    }

    public function getPermissions()
    {
        return collect(['create' => $this->options['create'],
                        'update' => $this->options['update'],
                        'delete' => $this->options['delete'],
                        'url'    => $this->getBaseUrl()]);
    }

    public function getBaseurl()
    {
        return $this->blueprint->getUrl();
    }

    protected function getRelationships()
    {
        $relationships = [];
        foreach ($this->blueprint->getFields()->all() as $id => $field) {
            if ($parent = $field->hasParent()) {
                $relationships[] = $parent;
            }
        }
        return $relationships;
    }
}
