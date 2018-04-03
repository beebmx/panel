<?php

namespace Beebmx\Panel\Fields;

class NumberField extends BaseField
{
    protected $type = 'number';
    protected $rules = ['numeric'];
    protected $defaults = [
        'cell' => 'panel-number-cell',
        'field' => 'panel-number-field',
    ];
}
