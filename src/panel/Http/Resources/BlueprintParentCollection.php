<?php

namespace Beebmx\Panel\Http\Resources;

use Beebmx\Panel\Features\Blueprintable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BlueprintParentCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection
        ];
    }
}
