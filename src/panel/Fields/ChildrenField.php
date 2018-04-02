<?php

namespace Beebmx\Panel\Fields;

class ChildrenField extends InputField
{
    public static $recordable = false;
    protected $defaults = [
        'cell' => 'panel-children-cell',
        'field' => false,
        'list' => true,
        'icon' => 'external-link-square'
    ];
}
