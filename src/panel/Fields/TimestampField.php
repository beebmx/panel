<?php

namespace Beebmx\Panel\Fields;

class TimestampField extends BaseField
{
    protected $type = 'timestamp';
    public static $recordable = false;

    protected $defaults = [
        'cell' => 'panel-timestamp-cell',
        'field' => false,
        'format' => '%d/%m/%Y'
    ];

    public function parseCell($row)
    {
        return $row->{ $this->id }->formatLocalized($this->format);
    }
}
