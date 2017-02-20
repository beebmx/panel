<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;
use App;
//use Beebmx\Panel\Fields\InputField;

class DateField extends BaseField{
    public $rule = '';
    public $type = 'text';
    
    /*public function cell(){
        $cell = new Brick('span', $this->value);
        return $cell;
    }*/

    public function input(){
        $input_container = new Brick('div');
        $input_container->addClass('input-group');
        $input_container->addClass('date');
        $input = new Brick('input');
       
       
        $input->attr = [
            'type'  => $this->type,
            'value' => $this->value,
            'id'    => $this->id,
            'name'  => $this->name,
            'autocomplete' => 'off',
            'data-locale' => App::getLocale(),
        ];
        $input->addClass('form-control');
        $input->addClass('input');
        

        $span = new Brick('span');
        $span->addClass('input-group-addon');

        $i = new Brick('i');
        $i ->addClass('glyphicon');
        $i ->addClass('glyphicon-th');
        $span->append($i);


        $input_container->addClass('datepicker');
        $input_container->append($input);
        $input_container->append($span);
        return $input_container;
    }
    
    /*public static function store($value){
        return $value;
    }*/

    /*
    public function inputShow() {
       return $this->cell();
    }*/
}