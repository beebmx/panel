<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\InputField;

class CheckboxField extends InputField{
    public $type = 'checkbox';
    public $rule = 'nullable|boolean';
    
    public function cell(){
        if ((int)$this->value){
            $i = new Brick('i', 'check');
        }else{
            $i = new Brick('i', 'close');
        }
        $i->addClass('material-icons');
        $i->addClass('field-checkbox');
        $cell = new Brick('div');
        $cell->addClass('text-center');
        $cell->append($i);
        return $cell;
    }
    
    public function input(){
        $input = new Brick('input');
        if ($this->value){
            $input->attr = [
                'type'  => $this->type,
                'value' => '1',
                'id'    => $this->id,
                'name'  => $this->name,
                'checked' => 'checked'
            ];
        }else{
            $input->attr = [
                'type'  => $this->type,
                'value' => '1',
                'id'    => $this->id,
                'name'  => $this->name
            ];
        }
        $input->addClass('input');
        $input->addClass('form-control');
        $input->addClass('checkbox');
        return $input;
    }
    
    public function content() {
        $content = new Brick('div');
        $content->addClass('field-content');
        $content->addClass('panel-checkbox');
        $content->append($this->input());
        $content->append($this->label());
        return $content;
    }
    
    public function template(){
        $element = $this->element();
        $element->append($this->content());
        $element->append($this->help());
        return $element;
    }
    
    public static function store($value, $field){
        return $value ? 1 : 0;
    }
    
    public function inputShow() {
        if ((int)$this->value){
            $i = new Brick('i', 'check');
        }else{
            $i = new Brick('i', 'close');
        }
        $i->addClass('material-icons');
        $i->addClass('field-checkbox');
        $cell = new Brick('div');
        $cell->append($i);
        return $cell;
    }
}