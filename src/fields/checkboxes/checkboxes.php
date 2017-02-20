<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;
use Beebmx\Panel\Model;

class CheckboxesField extends BaseField{
    public $rule = 'nullable';  
    public $type = 'checkbox';
    
    public function cell(){
        $cell = new Brick('span', $this->getText());
        return $cell;
    }
    
    private function getText(){
    	$selected = (array)json_decode($this->value, true);
    	$values = [];

 		if(is_array($this->opts)) {
 			$options = array_keys($this->opts);
 			$intersect = array_intersect($options, $selected);
            foreach ($this->opts as $value => $text){
            	foreach ($intersect as $option){
            		if ($option == $value){
            			array_push($values, $text);
            			break;
            		}
            	}
            }
            return implode(', ', $values);
        }else if(strtolower($this->opts) === 'class'){
        	$model = new Model($this->query['class']);
        	$cv = isset($this->query['value']) ? $this->query['value'] : 'id';
            $cl = isset($this->query['label']) ? $this->query['label'] : 'name';

            foreach($model->all() as $field){
            	foreach ($selected as $option){
            		if ($option == $field->id){
            			array_push($values, $field->{ $cl });
            			break;
            		}
            	}
            }
        	return implode(', ', $values);
        }

    }

    
    public function input(){
     	$input_container = new Brick('div');
        $input_container->addClass('checkboxes-container');  
    	foreach($this->build() as $option){
       		$input_container->append($this->option($option));
       	}
        
        return $input_container;
    }

    public function option($option){
    	$input_container = new Brick('div');
    	$input = new Brick('input');
    	$input->attr = [
                'type'  => $this->type,
                'value' => $option['value'],
                'id'	=> 'checkbox-'.$this->name.'-'.$option['value'],
                'name'  => $this->name.'[]',
                'checked' => $option['checked'],
            ];
        $input->addClass('checkbox');
        $label = new Brick('label', $option['label'].' ', ['for' => 'checkbox-'.$this->name.'-'.$option['value']]);
        $input_container->append($input);
        $input_container->append($label);
        $input_container->addClass('field-content');
        $input_container->addClass('panel-checkbox');
        $input_container->addClass('checkbox-inline');
        return $input_container;
    }

    public function build(){
    	$selected = (array)json_decode($this->value, true);

    	$options = [];
        if(is_array($this->opts)) {
        	$opts = array_keys($this->opts);
 			$intersect = array_intersect($opts, $selected);
            foreach($this->opts as $value => $label ){
            	$checked = '';
            	foreach ($intersect as $option){
            		if ($option == $value){
            			$checked = 'checked';
            			break;
            		}
            	}
                $options[] = ['value' => $value,
                              'label'  => $label,
                              'checked' => $checked ];
            }
        }else if(strtolower($this->opts) === 'class'){
        	$model = new Model($this->query['class']);
        	$cv = isset($this->query['value']) ? $this->query['value'] : 'id';
            $cl = isset($this->query['label']) ? $this->query['label'] : 'name';

            foreach($model->all() as $field){
            	$checked = '';
            	foreach ($selected as $option){
            		if ($option == $field->id){
            			$checked = 'checked';
            			break;
            		}
            	}
            	$options[] = ['value' => $field->{ $cv },
                              'label'  => $field->{ $cl },
                              'checked' => $checked ];
            }
        }
        return collect($options);
    }

    public static function store($value){
    	return json_encode($value);
    }

    
    public function inputShow() {
       return $this->cell();
    }
}