<?php

namespace Beebmx\Panel\Fields;

class InputField extends BaseField
{
    protected $type = 'input';
    protected $defaults = [
        'cell' => 'panel-text-cell',
        'icon' => false
    ];
}
