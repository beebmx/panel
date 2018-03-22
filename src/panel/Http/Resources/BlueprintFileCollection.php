<?php

namespace Beebmx\Panel\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BlueprintFileCollection extends ResourceCollection
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
            'data' => $this->getFiles($request)
        ];
    }

    protected function getFiles($request)
    {
        if ($this->collection->count()) {
            return $this->collection->map(function ($file, $key) {
                return [
                    'extension' => $file->extension(),
                    'filename' => $file->filename(),
                    'mime' => $file->mime(),
                    'rawsize' => $file->rawSize(),
                    'size' => $file->size(),
                    'type' => $file->type(),
                ];
            });
        } else {
            return $this->collection;
        }
    }
}
