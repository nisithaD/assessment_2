<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Routes as RoutesResources;

class Schedules extends JsonResource
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
            'route_id' => $this->route_id,
            'direction' => $this->direction,
            'start_timestamp' => $this->start_timestamp,
            'end_timestamp'=>$this->end_timestamp,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'route_data'=>RoutesResources::collection($this->whenLoaded('routeRelation')),

            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
