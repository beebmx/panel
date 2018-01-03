<?php

namespace Beebmx\Panel\Fields;

class PercentageField extends BaseField
{
    protected $type = 'text';
    protected $rules = ['numeric'];
    protected $defaults = [
        'cell' => 'panel-percentage-cell',
        'field' => 'panel-percentage-field',
    ];
}
