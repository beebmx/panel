<?php

namespace Beebmx\Panel;

class Fields
{
    protected $fields = [];
    public $original;

    public function __construct($fields)
    {
        $this->original = $fields;

        foreach ($fields as $id => $settings) {
            $this->setField($id, $settings);
        }
    }

    public function all()
    {
        return $this->fields;
    }

    public function getSettings()
    {
        $settings = [];
        foreach ($this->fields as $id => $field) {
            $settings[$id] = $field->attributes;
        }
        return $settings;
    }

    public function getIdField()
    {
        return collect($this->fields)->first(function ($field, $id) {
            return strtolower($field->getType()) === 'id';
        });
    }

    public function getIdKeyField()
    {
        return collect($this->fields)->filter(function ($field, $id) {
            return strtolower($field->getType()) === 'id';
        })->keys()->first();
    }

    protected function getField($id)
    {
        if (!$id) {
            return;
        }
        if (isset($this->fields[$id])) {
            return $this->fields[$id];
        }
    }

    protected function setField($id, $settings)
    {
        $classField = $this->getClassField($settings['type']);
        $this->fields[$id] = new $classField($id, $settings);
        ;
        return $this;
    }

    public function __get($id)
    {
        return $this->getField($id);
    }

    protected function getClassField($type)
    {
        $type = ucwords($type);
        if (class_exists('Beebmx\\Panel\\Fields\\' . $type . 'Field')) {
            return 'Beebmx\\Panel\\Fields\\' . $type . 'Field';
        } elseif (file_exists(app_path('Panel/Fields/' . $type . '/' . $type . '.php'))) {
            $filename = app_path('Panel/Fields/' . $type . '/' . $type . '.php');
            return $this->getFullNamespace($filename) . '\\' . $type . 'Field';
        } else {
            return 'Beebmx\\Panel\\Fields\\BaseField';
        }
    }
}
