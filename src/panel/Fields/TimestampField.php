<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Fields\BaseField;

class TimestampField extends BaseField
{
    protected $type = 'timestamp';
    public static $recordable = false;
    
    protected $defaults = [
        'cell'  => 'panel-timestamp-cell',
        'input' => false,
        'format' => '%d/%m/%Y'
    ];

    public function parseCell($row)
    {
        return $row->{ $this->id }->formatLocalized($this->format);
    }
}
