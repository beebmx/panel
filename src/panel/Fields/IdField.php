<?php

namespace Beebmx\Panel\Fields;

class IdField extends BaseField
{
    protected $type = 'id';
    public static $recordable = false;
    protected $defaults = [
        'field' => false
    ];
}
