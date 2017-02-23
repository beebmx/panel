<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;
use App;
use Carbon\Carbon;
//use Beebmx\Panel\Fields\InputField;

class DatetimeField extends BaseField{
    public $rule = '';
    public $type = 'text';
    public $js = ['panel_assets/js/moment-with-locales.js', 'panel_assets/js/bootstrap-datetimepicker.min.js'];
    
    public function cell(){
        if (isset($this->value)){
            $datetime = new Carbon($this->value);
            $cell = new Brick('span', $datetime->format('Y-m-d H:i'));
        }else{
            $cell = new Brick('span', $this->value);
        }
       
        return $cell;
    }

    
    public function input(){
        $input_container = new Brick('div');
        $input_container->addClass('input-group');
        $input_container->addClass('date');

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

        $glyphicon = new Brick('span');
        $glyphicon ->addClass('glyphicon');
        $glyphicon ->addClass('glyphicon-calendar');
        $span->append($glyphicon);

        $input_container->addClass('datetimepicker');
        $input_container->append($input);
        $input_container->append($span);
        return $input_container;

    }
    
    /*public static function store($value, $field){
        return $value;
    }*/

    
    public function inputShow() {
       return $this->cell();
    }
}