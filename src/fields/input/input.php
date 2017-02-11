<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;

class InputField extends BaseField{
    public function input(){
        $input = new Brick('input');
        $input->attr = [
            'type'  => $this->type,
            'value' => $this->value,
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