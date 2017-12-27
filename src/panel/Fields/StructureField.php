<?php

namespace Beebmx\Panel\Fields;

class StructureField extends BaseField
{
    protected $type = 'structure';
    protected $defaults = [
        'cell' => 'panel-structure-cell',
        'field' => 'panel-structure-field',
        'list' => false
    ];
}
