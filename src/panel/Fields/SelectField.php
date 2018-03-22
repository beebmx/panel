<?php

namespace Beebmx\Panel\Fields;

class SelectField extends BaseField
{
    protected $type = 'select';
    protected $defaults = [
        'field' => 'panel-select-field',
    ];

    public function parseCell($row)
    {
        if ($this->parent) {
            $separator = isset($this->query['separator']) ? $this->query['separator'] : '|';
            $text = isset($this->query['text']) ? $this->query['text'] : 'name';
            $value = [];
            foreach (explode($separator, $text) as $key) {
                $value[] = $row->{ $this->parent['relation'] }->{ $key };
            }
            return implode(' ', $value);
        } else {
            return $row->{ $this->id };
        }
    }
}
