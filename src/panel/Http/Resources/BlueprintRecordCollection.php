<?php

namespace Beebmx\Panel\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlueprintRecordCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
