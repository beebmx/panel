<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Fields\InputField;

class CheckboxField extends InputField
{
    protected $type = 'checkbox';
    protected $defaults = [
        'cell'  => 'panel-checkbox-cell',
        'input' => 'panel-text-field'
    ];
}
