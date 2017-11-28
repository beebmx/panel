<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Fields\InputField;

class TextField extends InputField
{
    protected $type = 'text';
    protected $defaults = [
        'input' => 'panel-text-field',
    ];
}
