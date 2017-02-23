<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;

class PercentageField extends BaseField{
    public $rule = 'nullable|regex:/^[0-9]+(?:\.[0-9]{1,2})?$/';  
    public $type = 'text';

    public function cell(){
        $cell = new Brick('span', strip_tags(($this->value*100).'%'));
        return $cell;
    }
    
    public function inputShow() {
    	return $this->cell();  
    }

    public static function store($value, $field){
        return $value/100;
    }

    public function input(){
        $input = new Brick('input');
        $input->attr = [
            'type'  => $this->type,
            'value' => (string)($this->value*100),
            'id'    => $this->id,
            'name'  => $this->name,
            'autocomplete' => 'off'
        ];
        $input->addClass('input');
        $input->addClass('form-control');
        
        if($this->readonly) {
            $input->attr['readonly'] = 'readonly';
        }
        if($this->placeholder) {
            $input->attr['placeholder'] = $this->placeholder;
        }
        
        return $input;
    }  
}