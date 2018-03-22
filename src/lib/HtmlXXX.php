<?php

namespace Beebmx\Panel;

class HtmlXXX{
    private static $void = ['area','base','br','col','command','embed','hr','img','input','keygen','link','meta','param','source','track','wbr'];
    
    public static function tag($tag, $content = null, $attr = []){
        
        if(is_array($content)) {
            $attr    = $content;
            $content = null;
        }
        $html = '<' . $tag;
        $attr = Html::attr($attr);
        
        if(!empty($attr)) $html .= ' ' . $attr;
        
        if (in_array($tag, Html::$void)){
            $html .= '/>';
        } else {
            $html .= '>' . $content . '</' . $tag . '>';
        }
        return $html;
    }
    
    private static function attr($name, $value = null){
        if(is_array($name)){
            $attributes = [];
            foreach($name as $key => $val) {
                $a = Html::attr($key, $val);
                if($a) $attributes[] = $a;
            }
            return implode(' ', $attributes);
        }
        
        if(empty($value) && $value !== '0' && $value !== 0) {
            return false;
        } else if($value === ' ') {
            return strtolower($name) . "=''";      
        } else if(is_bool($value)) {
            return $value === true ? strtolower($name) : '';
        } else {
            return strtolower($name) . "='" . ( is_array($value) ? implode(' ', $value) : $value ) . "'";      
        }
    }
}
