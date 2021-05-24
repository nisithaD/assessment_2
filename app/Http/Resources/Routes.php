<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Routes extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'node_one' => $this->node_one,
            'node_two' => $this->node_two,
            'route_number' => $this->route_number,
            'distance'=>$this->distance,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
