<?php

namespace Beebmx\Panel;

use Beebmx\Panel\Blueprint;
use Beebmx\Panel\Exception\BlueprintNotExists;

trait Administrable
{
    public function getBlueprint()
    {
        if (Blueprint::exists($this->blueprint)){
            return new Blueprint(Blueprint::path($this->blueprint));
        }else{
            throw new BlueprintNotExists;
        }
    }
}