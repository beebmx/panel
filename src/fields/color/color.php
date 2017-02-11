<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;

class ColorField extends BaseField{
    public function cell(){
        $cell = new Brick('span', false);
        if (!empty($this->value)){
            $cell->attr = [
                'style' => 'background-image:none; background-color:'.$this->value.';'
            ];
        }
        $cell->addClass('color');
        return $cell;
    }
    public function input(){
        $input = new Brick('input');
        $input->attr = [
            'type'  => 'text',
            'value' => $this->value,
            'id'    => $this->id,
            'name'  => $this->name,
            'autocomplete' => 'off'
        ];
        
        $input->addClass('input');
        $input->addClass('color');
        $input->addClass('form-control');
        
        if(is_array($this->opts)) {
            if(isset($this->opts['colors'])) {
                $input->attr['data-colors'] = implode('|', $this->opts['colors']);
            }else{
                if(!isset($this->opts['colors'])) {
                    $input->attr['data-colors'] = implode('|', $this->opts);
                }
            }
        }   
        return $input;
    }
    public function inputShow() {
        return $this->cell();
    }
}