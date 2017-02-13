<?php

namespace Beebmx\Panel\Fields;

//use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\InputField;

class EmailField extends InputField{
    public $type = 'email';
    public $rule = 'nullable|email';
}