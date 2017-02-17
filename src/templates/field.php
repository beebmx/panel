<?php

namespace App\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;
//use Beebmx\Panel\Fields\InputField;

class NameField extends BaseField{
    public $rule = '';
    public $css = [];
    public $js = [];
    
    /*public function cell(){
        $cell = new Brick('span', $this->value);
        return $cell;
    }*/

    /*
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
                
        return $input;
    }*/
    
    /*public static function store($value){
        return $value;
    }*/

    /*
    public function inputShow() {
       return $this->cell();
    }*/
}