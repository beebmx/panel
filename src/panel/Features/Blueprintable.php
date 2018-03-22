<?php

namespace Beebmx\Panel\Features;

use Beebmx\Panel\Blueprint;
use Beebmx\Panel\Exception\BlueprintNotExists;

trait Blueprintable
{
    protected function getBlueprint($model){
        if (Blueprint::exists($model)){
            return new Blueprint(Blueprint::path($model));
        }else{
            throw new BlueprintNotExists;
        }
    }
}
