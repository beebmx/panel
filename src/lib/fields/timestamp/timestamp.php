<?php

namespace Beebmx\Panel\Fields;

use Beebmx\Panel\BrickXXX;
use Beebmx\Panel\Fields\BaseFieldXXX;
use Carbon\Carbon;

class TimestampFieldXXX extends BaseField{
    public static $stored = false;
    public function cell(){
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->value);
        $cell = new Brick('span', $date->toDateString());
        return $cell;
    }
}