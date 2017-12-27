<?php

namespace Beebmx\Panel\Fields;

class EmailField extends InputField
{
    protected $type = 'email';
    protected $rules = ['email'];
    protected $defaults = [
        'field' => 'panel-email-field'
    ];
}
