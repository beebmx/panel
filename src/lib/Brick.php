<?php
namespace Beebmx\Panel;

use Beebmx\Panel\Html;

class Brick{
    public $tag    = null;
    public $attr   = [];
    public $html   = null;
    public $events = [];
    
    public function __construct($tag, $html = false, $attr = []){
        $this->tag = $tag;
        $this->html = $html;
        $this->attr = $attr;
    }
    
    public function __toString() {
        $this->attr['class'] = $this->classNames();
        return Html::tag($this->tag, $this->html, $this->attr);
    }
    
    public function classNames() {
        if(!isset($this->attr['class'])){
            $this->attr['class'] = '';
        }else if (is_array($this->attr['class'])){
            $this->attr['class'] = implode(' ', $this->attr['class']);
        }
        return $this->attr['class'];
    }
    
    public function html($html = null){
        $this->html = $html;
        return $this;
        
    }
    
    public function addClass($class) {
        $classNames = explode(' ', $this->classNames());
        if (!empty($classNames)){
            if (!in_array($class, $classNames)){
                $classNames[] = $class;
            }
            $this->attr['class'] = trim(implode(' ', $classNames));
        }else{
            $this->attr['class'] = $class;
        }
    }
    
    public function removeClass($class) {        
        $classNames = explode(' ', $this->classNames());
        if (in_array($class, $classNames)){
            $classes = array_diff($classNames, [$class]);
        }
        $this->attr['class'] = implode(' ', $classNames);
    }
    
    public function replaceClass($classA, $classB) {
        return $this->removeClass($classA)->addClass($classB);
    }
    
    public function prepend($html) {
        if ($html !== null){
            $this->html = $html . $this->html;
        }
    }
    
    public function append($html) {
        if ($html !== null){
            $this->html = $this->html . $html;
        }
    }
}