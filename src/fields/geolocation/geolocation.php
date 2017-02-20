<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;

class GeolocationField extends BaseField{
    public $rule = 'nullable|regex:/^[+-]?[0-9]{1,9}(?:\.[0-9]{1,16}),[+-]?[0-9]{1,9}(?:\.[0-9]{1,16})?$/';
    
    public function input(){
        $content = new Brick('div');
        $content->addClass('map-geolocation');
        $content->attr['data-api'] = config('panel.maps_api');
        
        $input_group = new Brick('div');
        $input_group->addClass('input-group');
        
        $search = new Brick('input');
        $search->attr = [
            'type'  => 'text',
            'value' => '',
            'id'    => $this->id.'-search',
            'name'  => $this->name.'-search',
            'autocomplete' => 'off'
        ];
        $search->addClass('map-search');
        $search->addClass('input');
        $search->addClass('form-control');
        
        $btn_group = new Brick('span');
        $btn_group->addClass('input-group-btn');
        
        $btn = new Brick('button', __('panel::form.search'), [
            'type'  => 'button',
            'id'    => $this->id.'-search',
            'name'  => $this->name.'-search',
            'autocomplete' => 'off'
        ]);
        $btn->addClass('map-button');
        $btn->addClass('btn');
        $btn->addClass('btn-primary');
        
        $btn_group->append($btn);
        
        $input_group->append($search);
        $input_group->append($btn_group);
        
        $canvas = new Brick('div');
        $canvas->addClass('map-canvas');
        $canvas->attr['style'] = isset($this->opts['height']) ? 'height: '.$this->opts['height'].'px' : 'height: 300px';
        
        $input = new Brick('input');
        $input->attr = [
            'type'  => 'text',
            'value' => $this->value,
            'id'    => $this->id,
            'name'  => $this->name,
            'autocomplete' => 'off'
        ];
        $input->addClass('input');
        $input->addClass('form-control');
        $input->addClass('map');
        
        $input->attr['data-lat'] = isset($this->opts['lat']) ? $this->opts['lat'] : 24.1212526;
        $input->attr['data-lng'] = isset($this->opts['lng']) ? $this->opts['lng'] : -102.5449103;
        $input->attr['data-zoom'] = isset($this->opts['zoom']) ? $this->opts['zoom'] : 6;
        
        $content->append($input_group);
        $content->append($canvas);
        $content->append($input);
        
        return $content;
    }
}
