<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\InputField;

class CurrencyField extends InputField{
    public $rule = 'nullable|regex:/^[0-9]+(?:\.[0-9]{1,2})?$/';  
    public $type = 'text';
    
    public function cell(){
        $cell = new Brick('span', strip_tags('$ '.$this->value));
        return $cell;
    }
    
    public function inputShow() {
    	return $this->cell();  
    }
}