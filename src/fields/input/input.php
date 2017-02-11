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
        /*
        if(!is_array($this->value())) {
        $input->val(html($this->value(), false));
        }
        
        
        if($this->readonly()) {
        $input->attr('tabindex', '-1');
        $input->addClass('input-is-readonly');
        }
        */
        
        return $input;
    }
    
    
}