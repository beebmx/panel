<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\InputField;

class PasswordField extends InputField{
    public $type = 'password';
    public static $updateEmpty = false;
    
    public function input(){
        $input = new Brick('input');
        $input->attr = [
            'type'  => $this->type,
            'value' => '',
            'id'    => $this->id,
            'name'  => $this->name
        ];
        $input->addClass('input');
        $input->addClass('form-control');
        
        return $input;
    }
    public static function store($value, $field){
        return bcrypt($value);
    }
    public function validate($id = false, $idField = false){
        $this->rules = [];
        if ($this->required && !$id){
		    $this->rules[] = 'required';
	    }
        if ($this->unique && $id){
		    $this->rules[] = 'unique:'.$this->unique.','.$this->id.','.$id;
	    }else if ($this->unique){
		    $this->rules[] = 'unique:'.$this->unique.','.$this->id;
	    }
	    if ($this->validate){
    	    $this->rules[] = $this->validate;
        }
        
        return implode('|', $this->rules);
    }
    public function inputShow() {
        $input = new Brick('div', '•••••••••••••••');
        $input->addClass('password');
        $input->addClass('view');
        return $input;
    }
}