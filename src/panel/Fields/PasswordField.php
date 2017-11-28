<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Fields\InputField;

class PasswordField extends InputField
{
    protected $type = 'password';
    public static $updatebleEmpty = false;
    protected $defaults = [
        'cell'  => false,
        'input' => 'panel-password-field',
        'list'  => false
    ];
}
