<?php

namespace Beebmx\Panel\Fields;

class CheckboxesField extends InputField
{
    protected $type = 'checkboxes';
    protected $defaults = [
        'field' => 'panel-checkboxes-field'
    ];

    public function parseCell($row)
    {    
        if (!empty($row->{ $this->id })){
            $values = explode(',', $row->{ $this->id });
            if ($this->parent) {
                $separator = isset($this->query['separator']) ? $this->query['separator'] : '|';
                $text = isset($this->query['text']) ? $this->query['text'] : 'name';
                $model = get_class(  $row->{ $this->parent['relation'] }()->getRelated() ) ;
                $value = $this->getModelValues($separator, $text, $model, $values);
                return implode(', ', $value);
            }else{
                foreach ($values as $key){
                    $value[] = $this->attributes['options'][$key];
                }
                return implode(', ', $value);
            }
        }
        return $row->{ $this->id };
    }

    protected function getModelValues($separator, $text, $model, $values)
    {
        $value = [];
        $selected = $model::find($values);
        foreach ($selected as $key){
            $val = [];
            foreach (explode($separator, $text) as $k) {
                $val[] = $key->{ $k };
            }
            $value[] = implode(' ', $val );
        }
        return $value;
    }
}
