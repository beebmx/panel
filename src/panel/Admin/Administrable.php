<?php

namespace Beebmx\Panel;

use Beebmx\Panel\Blueprint;
use Beebmx\Panel\Exception\BlueprintNotExists;

trait Administrable
{
    public function getBlueprint()
    {
        if (Blueprint::exists($this->blueprint)) {
            return tap(new Blueprint(Blueprint::path($this->blueprint)))->setId($this->id);
        } else {
            throw new BlueprintNotExists;
        }
    }
}
