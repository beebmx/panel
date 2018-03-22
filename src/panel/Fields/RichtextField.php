<?php

namespace Beebmx\Panel\Fields;

class RichtextField extends BaseField
{
    protected $type = 'richtext';
    protected $defaults = [
        'cell' => 'panel-html-cell',
        'field' => 'panel-richtext-field'
    ];
}
