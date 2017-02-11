<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;

class ModelField extends BaseField{
    public static $stored = false;
    public static $recordable = false;
    public function cell(){
        $cell = new Brick('div', $this->value->{$this->attr});
        return $cell;
    }
}