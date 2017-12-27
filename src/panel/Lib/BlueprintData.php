<?php

namespace Beebmx\Panel;

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
            'storage' => str_singular($this->blueprint->getFilename()),
            'paginate' => config('panel.paginate'),
            'create' => true,
            'update' => true,
            'delete' => true
        ];
        $order = [
            'field' => 'id',
            'sort' => 'asc'
        ];

        $this->options = array_merge($options, $blueprint->options);
        $this->order = array_merge($order, $blueprint->order);
    }

    public function all()
    {
        $relationships = $this->getRelationships();
        $q = request()->has('q') ?: false;
        if (!$q) {
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

    public function find($id)
    {
        if ($data = $this->class::find($id)) {
            return $data;
        } else {
            return $this->getEmptyData();
        }
    }

    public function save($id = false)
    {
        if ($id) {
            $this->setId($id);
        }
        $inputs = request()->validate($this->validation());
        if (!$id && request()->isMethod('post')) {
            $model = new $this->class;
        } elseif ($id && request()->isMethod('put')) {
            $model = $this->class::find($this->getId());
        }

        foreach ($inputs as $id => $value) {
            $model->$id = $value;
        }

        $model->save();

        return $model;
    }

    public function delete()
    {
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

    public function getHeaders()
    {
        return collect($this->blueprint->fields()->all())->filter(function ($field, $id) {
            return $field->list;
        })->map(function ($field, $id) {
            return collect($field->attributes)->only('id', 'label', 'cell', 'mobile', 'parent', 'maxCellChars');
        });
    }

    public function getPermissions()
    {
        return collect(['create' => $this->options['create'],
        'update' => $this->options['update'],
        'delete' => $this->options['delete'],
        'url' => $this->getBaseUrl()]);
    }

    public function getBaseurl()
    {
        return $this->blueprint->getUrl();
    }

    public function getAllRelatinshipsData()
    {
        $relationships = [];
        foreach ($this->blueprint->fields()->all() as $id => $field) {
            if ($parent = $field->hasParent()) {
                $relationships[$parent['relation']] = $parent['model']::all();
            }
        }
        return $relationships;
    }

    protected function validation()
    {
        $validations = [];
        foreach (request()->only($this->blueprint->fields()->recordableKeys()) as $id => $field) {
            $validations[$id] = $this->blueprint->fields()->{ $id }->validate($this->getId(), $field);
        }
        return $validations;
    }

    protected function getRelationships()
    {
        $relationships = [];
        foreach ($this->blueprint->fields()->all() as $id => $field) {
            if ($parent = $field->hasParent()) {
                $relationships[] = $parent['relation'];
            }
        }
        return $relationships;
    }

    protected function getEmptyData()
    {
        return collect($this->blueprint->fields()->all())->map(function ($field, $id) {
            return '';
        });
    }
}
