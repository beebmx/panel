<?php

namespace Beebmx\Panel\Fields;

class NumberField extends BaseField
{
    protected $type = 'number';
    protected $rules = ['numeric'];
    protected $defaults = [
        'field' => 'panel-number-field'
    ];
}
