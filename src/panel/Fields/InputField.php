<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Fields\BaseField;

class InputField extends BaseField
{
    protected $type = 'input';
    protected $defaults = [
        'cell'  => 'panel-text-cell'
    ];
}
