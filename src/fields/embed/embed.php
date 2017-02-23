<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;
use App;

class EmbedField extends BaseField{
    public $rule = 'nullable|string';
    public function cell(){
        $limit = isset($this->opts['limit']) ? $this->opts['limit'] : 20;
        $cell = new Brick('span', str_limit(strip_tags(strip_tags($this->value)), $limit));
        return $cell;
    }
    public function input(){
        $height = isset($this->opts['height']) ? $this->opts['height'] : 250;
        $input = new Brick('textarea', $this->value, [
            'id'    => $this->id,
            'name'  => $this->name,
            'style' => 'height:'.$height.'px'
        ]);
        $input->addClass('input');
        $input->addClass('embed');
        $input->addClass('form-control');
        
        return $input;
    }
    public static function store($value, $field){
        $type = isset($field['options']['type']) ? $field['options']['type'] : 'iframe';
        switch ($type){
            case 'css':
                return strip_tags($value, '<style>');
                break;
            case 'link':
                return strip_tags($value, '<link>');
                break;
            case 'js':
                return strip_tags($value, '<script>');
                break;
            case 'meta':
                return strip_tags($value, '<meta>');
                break;
            case 'embed':
                return strip_tags($value, '<embed>');
                break;
            case 'object':
                return strip_tags($value, '<object>');
                break;
            case 'canvas':
                return strip_tags($value, '<canvas>');
                break;
            case 'jscss':
                return strip_tags($value, '<style><script>');
                break;
            case 'mix':
                return strip_tags($value, '<style><script><iframe>');
                break;
            default:
                return strip_tags($value, '<iframe>');
        }
    }
    public function inputShow() {
        $height = isset($this->opts['height']) ? $this->opts['height'] : 250;
        $canvas = new Brick('div', null, [
            'style' => 'height:'.$height.'px'
        ]);
        $canvas->addClass('embed');
        $canvas->addClass('view');
        
        $textarea = new Brick('div', e($this->value));
        
        $canvas->append($textarea);
        return $canvas;
    }
}