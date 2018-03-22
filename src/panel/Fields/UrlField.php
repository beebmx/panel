<?php

namespace Beebmx\Panel\Fields;

class UrlField extends BaseField
{
    protected $type = 'url';
    protected $rules = ['url'];
    protected $defaults = [
        'field' => 'panel-url-field',
    ];
}
