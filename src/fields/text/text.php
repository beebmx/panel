<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Fields\InputField;

class TextField extends InputField{
    public $type = 'text';
    public $rule = 'nullable|string';
}