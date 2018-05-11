<?php

namespace Beebmx\Panel\Fields;

class PasswordField extends InputField
{
    protected $type = 'password';
    public static $updatebleEmpty = false;
    protected $defaults = [
        'cell' => false,
        'field' => 'panel-password-field',
        'list' => false
    ];

    public static function process($value)
    {
        return bcrypt($value);
    }
}
