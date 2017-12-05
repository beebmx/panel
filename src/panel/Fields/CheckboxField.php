<?php

namespace Beebmx\Panel\Fields;

class CheckboxField extends InputField
{
    protected $type = 'checkbox';
    protected $defaults = [
        'cell' => 'panel-checkbox-cell',
        'field' => 'panel-text-field'
    ];
}
