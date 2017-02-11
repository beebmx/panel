<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;
use Beebmx\Panel\Model;

class SelectField extends BaseField{
    private function getText(){
        if(is_array($this->opts)) {
            foreach($this->opts as $value => $text ){
                if ((string) $value === $this->value){
                    return $text;
                }
            }
        }else if(strtolower($this->opts) === 'class'){
            $model = new Model($this->query['class']);
            $find = $model->find($this->query['value'], $this->value);
            return $find->{ $this->query['text'] };
        }else if(strtolower($this->opts) === 'file'){
            return $this->value;
        }
    }
    public function cell(){
        $cell = new Brick('span', $this->getText());
        return $cell;
    }
    public function input(){
        $input_container = new Brick('div');
        $input_container->addClass('select-container');
        
        $input = new Brick('select');
        $input->attr = [
            'id'    => $this->id,
            'name'  => $this->name
        ];
        if(!is_array($this->opts)){
            if(strtolower($this->opts) === 'file'){
                $input->addClass('dynamic');
                $input->addClass('file');
                $input->attr['data-type'] = 'file';
                $input->attr['data-init'] = $this->value;
            }
        }
        
        $input->addClass('input');
        $input->addClass('form-control');
        
        foreach($this->build() as $option){
            $input->append($this->option($option, $this->value == $option['value']));
        }
        
        $input_container->append($input);
        
        $arrow = new Brick('span');
        $arrow->addClass('arrow');
        $input_container->append($arrow);
        
        return $input_container;
    }
    public function option($option, $selected = false){
        return new Brick('option', $option['text'], [
                         'value'    => $option['value'],
                         'selected' => $selected
        ]);
    }
    public function build(){
        $options = [];
        if(is_array($this->opts)) {
            $options[] = ['value' => ' ',
                          'text'  => ' Seleccione una opción'];
            foreach($this->opts as $value => $text ){
                $options[] = ['value' => $value,
                              'text'  => $text];
            }
        }else if(strtolower($this->opts) === 'class'){
            $model = new Model($this->query['class']);
            foreach($model->all() as $field){
                $options[] = ['value' => $field->{ $this->query['value'] },
                              'text'  => $field->{ $this->query['text'] }];
            }
        }
        else if(strtolower($this->opts) === 'file'){
            $options[] = ['value' => ' ',
                          'text'  => ' Seleccione una opción'];
        }
        return collect($options)->sortBy('text');
    }
    public function inputShow() {
        return $this->cell();
    }
}