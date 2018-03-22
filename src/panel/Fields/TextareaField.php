<?php

namespace Beebmx\Panel\Fields;

class TextareaField extends BaseField
{
    protected $type = 'textarea';
    protected $defaults = [
        'cell' => 'panel-html-cell',
        'field' => 'panel-textarea-field'
    ];
}
