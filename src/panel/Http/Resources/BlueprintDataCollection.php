<?php

namespace Beebmx\Panel\Http\Resources;

use Beebmx\Panel\Features\Blueprintable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BlueprintDataCollection extends ResourceCollection
{
    use Blueprintable;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->getRows($request)
        ];
    }

    protected function getRows($request)
    {
        if ($blueprint = $this->collection->count()) {
            $blueprint = $this->collection->first()->getBlueprint();
            $fields = $blueprint->fields();
            $headers = $blueprint->data()->getHeaders();

            $idKey = $fields->getIdKeyField();
            $all = $fields->all();

            return $this->collection->map(function ($field, $id) use ($headers, $all, $idKey) {
                $row = [];
                foreach ($headers as $key => $cell) {
                    $row[$key] = $all[$key]->parseCell($field);
                }
                $row['panel_row_id'] = $field[$idKey];
                return $row;
            });
        } else {
            return $this->collection;
        }
    }
}
