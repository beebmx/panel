<?php

namespace Beebmx\Panel;

class BlueprintData
{
    protected $blueprint;
    protected $parent;
    protected $id = false;
    protected $class;

    public function __construct($blueprint, $parent = false)
    {
        $this->blueprint = $blueprint;
        $this->parent = $parent;
        $this->class = $this->blueprint->getClass();
        $options = [
            'storage' => str_singular($this->blueprint->getFilename()),
            'paginate' => config('panel.paginate'),
            'create' => true,
            'update' => true,
            'delete' => true,
            'search' => 'name'
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
        $q = request()->has('q') ? request()->input('q') : false;
        if (!$q) {
            if ($this->blueprint->parent) {
                if (count($relationships)) {
                    return $this->class::with($relationships)
                                ->where($this->blueprint->parent, $this->parent)
                                ->orderBy($this->order['field'], $this->order['sort'])
                                ->paginate($this->options['paginate']);
                } else {
                    return $this->class::where($this->blueprint->parent, $this->parent)
                                ->orderBy($this->order['field'], $this->order['sort'])
                                ->paginate($this->options['paginate']);
                }
            } else {
                if (count($relationships)) {
                    return $this->class::with($relationships)
                                ->orderBy($this->order['field'], $this->order['sort'])
                                ->paginate($this->options['paginate']);
                } else {
                    return $this->class::orderBy($this->order['field'], $this->order['sort'])
                                ->paginate($this->options['paginate']);
                }
            }
        } else {
            $search = $this->getAllSearchableFields($q);
            if (count($relationships)) {
                $model = $this->class::with($relationships)
                                ->orderBy($this->order['field'], $this->order['sort']);
            } else {
                $model = $this->class::orderBy($this->order['field'], $this->order['sort']);
            }
            if ($this->blueprint->parent) {
                $model->where($this->blueprint->parent, $this->parent);
            }
            $first = false;
            foreach ($search as $w) {
                if (!$first) {
                    $first = true;
                    $model->where($w[0], $w[1], $w[2]);
                } else {
                    $model->orWhere($w[0], $w[1], $w[2]);
                }
            }
            return $model->paginate($this->options['paginate']);
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
            foreach ($inputs as $id => $value) {
                $model->$id = $this->blueprint->fields()->{ $id }->process($value);
            }
        } elseif ($id && request()->isMethod('put')) {
            $model = $this->class::find($this->getId());
            foreach ($inputs as $id => $value) {
                $field = $this->blueprint->fields()->{ $id };
                if ($field->updatebleEmpty || !empty($value)) {
                    $model->$id = $field->process($value);
                }
            }
        }

        if ($this->blueprint->parent && $this->parent) {
            $model->{$this->blueprint->parent} = $this->parent;
        }

        $model->save();

        return $model;
    }

    public function delete($id)
    {
        $this->setId($id);
        $record = $this->class::find($this->getId());
        $record->delete();

        return $record;
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

    protected function getAllSearchableFields($q)
    {
        $search = [];
        if (is_array($this->options['search'])) {
            $search = [];
            foreach ($this->options['search'] as $field => $option) {
                if ($option !== null) {
                    $search[] = [$field, $option, $q];
                } else {
                    $search[] = [$field, 'LIKE', '%' . $q . '%'];
                }
            }
        } else {
            $search[] = [$this->options['search'], 'LIKE', '%' . $q . '%'];
        }
        return $search;
    }
}
