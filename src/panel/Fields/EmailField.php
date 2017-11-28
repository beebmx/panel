<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Fields\InputField;

class EmailField extends InputField
{
    protected $type = 'email';
    protected $defaults = [
        'input' => 'panel-email-field'
    ];
}
