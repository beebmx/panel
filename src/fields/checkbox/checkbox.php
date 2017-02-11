<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\InputField;

class CheckboxField extends InputField{
    public $type = 'checkbox';
    
    public function cell(){        
        $i = new Brick('i');
        if ((int)$this->value){
            $i->addClass('ti-check');
        }else{
            $i->addClass('ti-close');
        }
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
                'value' => 'true',
                'id'    => $this->id,
                'name'  => $this->name,
                'checked' => 'checked'
            ];
        }else{
            $input->attr = [
                'type'  => $this->type,
                'value' => 'true',
                'id'    => $this->id,
                'name'  => $this->name
            ];
        }
        $input->addClass('input');
        $input->addClass('form-control');
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
    
    public static function store($value){
        return $value ? 1 : 0;
    }
    
    public function inputShow() {
        $i = new Brick('i');
        if ((int)$this->value){
            $i->addClass('ti-check');
        }else{
            $i->addClass('ti-close');
        }
        $cell = new Brick('div');
        $cell->append($i);
        return $cell;
    }
}