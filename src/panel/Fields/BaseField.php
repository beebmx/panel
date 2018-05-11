<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Features\HasSettings;

class BaseField
{
    use HasSettings;

    public $id;
    public $error;
    public $attributes = [];

    protected $type = 'base';
    protected $rules = [];

    public static $listable = true;
    public static $recordable = true;
    public static $updatable = true;
    public static $updatebleEmpty = true;

    public function __construct($id, $settings, $error = false)
    {
        $this->id = $id;
        $this->settings = $settings;
        $this->error = $error;

        foreach ($this->settings as $key => $value) {
            $this->setSetting($key, $value);
        }
        $this->setDefaults();
        $this->hasParent();
        $this->attributes = $this->settings;
    }

    public function parseCell($row)
    {
        return $row->{ $this->id };
    }

    public function getType()
    {
        return $this->type;
    }

    protected function getDefaults()
    {
        return ['id' => $this->id,
                'label' => ucfirst($this->id),
                'cell' => 'panel-cell',
                'field' => 'panel-text-field',
                'parent' => false,
                'mobile' => true,
                'list' => true,
                'width' => 'full',
                'recordable' => static::$recordable];
    }

    protected function getSettings()
    {
        return collect($this->settings)->toJson();
    }

    public function hasParent()
    {
        return $this->parent;
    }

    public function validate($id = false, $value = false)
    {
        $rules = [];
        if ($this->required) {
            $rules[] = 'required';
        }
        return array_merge($rules, $this->rules);
    }

    public static function process($value)
    {
        return $value;
    }

    public function __toString()
    {
        return $this->getSettings();
    }
}
