<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;

class TextareaField extends BaseField{
    public $rule = 'nullable|string';
    public function cell(){
        $limit = isset($this->opts['limit']) ? $this->opts['limit'] : 20;
        $cell = new Brick('span', str_limit(strip_tags($this->value), $limit));
        return $cell;
    }
    public function input(){
        $input = new Brick('textarea', $this->value, [
            'id'    => $this->id,
            'name'  => $this->name
        ]);
        $input->addClass('input');
        $input->addClass('textarea');
        $input->addClass('form-control');
        
        if(is_array($this->opts)) {
            if(isset($this->opts['height'])) {
                $input->attr['data-height'] = $this->opts['height'];
            }
            if(isset($this->opts['plugins'])) {
                $input->attr['data-plugins'] = $this->opts['plugins'];
            }
            if(isset($this->opts['toolbar'])) {
                $input->attr['data-toolbar'] = $this->opts['toolbar'];
            }
        }
        return $input;
    }
    public function inputShow() {
        $height = isset($this->opts['height']) ? $this->opts['height'] : 250;
        $canvas = new Brick('div', null, [
            'style' => 'height:'.$height.'px'
        ]);
        $canvas->addClass('textarea');
        $canvas->addClass('view');
        
        $textarea = new Brick('div', $this->value);
        
        $canvas->append($textarea);
        return $canvas;
    }
}