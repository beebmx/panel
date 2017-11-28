<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Fields\BaseField;

class SelectField extends BaseField
{
    protected $type = 'select';
    public function hasParent()
    {
        if (strtolower($this->options) === 'class') {
            $this->parent = $this->query['parent'];
        }

        return $this->parent;
    }

    public function parseCell($row)
    {
        if ($this->parent) {
            $separator = isset($this->query['separator']) ? $this->query['separator'] : '|';
            $text = isset($this->query['text']) ? $this->query['text'] : 'name';
            $value = [];
            foreach(explode($separator, $text) as $key){
                $value[] = $row->{ $this->parent }->{ $key };
            }
            return implode(' ', $value);
        } else {
            return $row->{ $this->id };
        }
    }
}
