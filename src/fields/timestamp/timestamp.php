<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\Brick;
use Beebmx\Panel\Fields\BaseField;
use Carbon\Carbon;

class TimestampField extends BaseField{
    public static $stored = false;
    public function cell(){
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->value);
        $cell = new Brick('span', $date->toDateString());
        return $cell;
    }
}