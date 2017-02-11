<?php
namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;

class BaseField{
    public $id;
    public $name;
    public $label;
    public $options;
    public $value;
    public $input;
    public $help;
    public $error;
    
    public $required;
    public $unique;
    public $readonly;
    public $placeholder;
    public $opts;
    public $query;
    public $fields;
    public $limit;
    public $width;
    public $display;
    public $attr;
    public $validate;
    public $rule = false;
    public $rules;
    
    public static $recordable = true;
    public static $stored = true;
    public static $updateEmpty = true;
    /*
    public $disabled = false;
    public $readOnly = false;
    public $hasError = false;
    */
    
    public function __construct($id, $options, $error = false, $prefix = false)
    {
        if (!$prefix){
            $this->id = $id;
            $this->name = $id;
        }else{
            $this->id = $prefix.'-'.$id;
            $this->name = $prefix.'-'.$id;
        }
        $this->options = $options;
        $this->label = $options['name'];
        
        $this->required = isset($options['required']) ? $options['required'] : false;
        $this->unique = isset($options['unique']) ? $options['unique'] : false;
        $this->readonly = isset($options['readonly']) ? $options['readonly'] : false;
        $this->placeholder = isset($options['placeholder']) ? $options['placeholder'] : false;
        $this->validate = isset($options['validate']) ? $options['validate'] : false;
        $this->opts = isset($options['options']) ? $options['options'] : false;
        $this->query = isset($options['query']) ? $options['query'] : false;
        $this->fields = isset($options['fields']) ? $options['fields'] : false;
        $this->limit = isset($options['limit']) ? $options['limit'] : false;
        $this->width = isset($options['width']) ? $options['width'] : 'col-xs-12';
        $this->display = isset($options['display']) ? $options['display'] : false;
        $this->attr = isset($options['attr']) ? $options['attr'] : false;
        
        $this->error = $error ? $error : false;
    }
    
    public function cell(){
        $cell = new Brick('span', $this->value);
        return $cell;
    }
    
    public function element() {
        $element = new Brick('div');
        $element->addClass('form-group');
        $element->addClass($this->width);
        if($this->error) {
            $element->addClass('field-error');
        }
        return $element;
    }
    
    public function label() {

        if(!$this->label) return null;
        
        $label = new Brick('label', $this->label.' ', ['for' => $this->id]);
        //$label->addClass('label');
        
        //$label->attr('for', $this->id);
        
        if($this->required) {
            $label->append(new Brick('abbr', '*', ['title' => 'Requerido']));
        }
        
        return $label;
    
    }
    
    public function help() {
    
        if(!$this->help) return null;
        
        $help = new Brick('div', $this->help);
        $help->addClass('field-help');
        //$help->html($this->help);
        return $help;
    
    }
    
    public function error() {
    
        if(!$this->error) return null;
        
        $error = new Brick('div');
        $error->addClass('errors');
        foreach($this->error as $err){
            $e = new Brick('div', $err);
            $error->append($e);
        }
        //$error->html($this->error);
        return $error;
    
    }
    
    public function input() {
        return $this->input;
    }
    
    public function content() {
    
        $content = new Brick('div');
        $content->addClass('field-content');
        $content->append($this->input());
        //$content->append($this->icon());
        
        return $content;
    }
    
    public function template(){
        $element = $this->element();
        $element->append($this->label());
        $element->append($this->content());
        $element->append($this->error());
        $element->append($this->help());
        return $element;
    }
    
    public function labelShow(){
        if(!$this->label) return null;
        
        $label = new Brick('div', $this->label);
        $label->addClass('label');
        $label->addClass('view');
        
        return $label;
    }
    
    public function contentShow() {
    
        $content = new Brick('div');
        $content->addClass('field-content');
        $content->append($this->inputShow());
        
        return $content;
    }
    
    public function inputShow() {
        return $this->value;
    }
    
    public function show(){
        $element = $this->element();
        $element->append($this->labelShow());
        $element->append($this->contentShow());
        return $element;
    }
    
    public static function store($value){
        return $value;
    }
    
    public function ignoreOnEmpty(){
        return !$this->updateEmpty;
    }
    
    public function modal(){
        return false;
    }
    
    //ID is used to verify if the validation is for a new record or update record
    public function validate($id = false, $idField = false){
        $this->rules = [];
        if ($this->required){
		    $this->rules[] = 'required';
	    }
        if ($this->unique && $id){
		    $this->rules[] = 'unique:'.$this->unique.','.$this->id.','.$id.','.$idField;
	    }else if ($this->unique){
		    $this->rules[] = 'unique:'.$this->unique.','.$this->id;
	    }
	    if ($this->rule){
		    $this->rules[] = $this->rule;
	    }
	    if ($this->validate){
    	    $this->rules[] = $this->validate;
        }
        
        return implode('|', $this->rules);
    }
}