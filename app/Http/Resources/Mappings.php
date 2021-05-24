<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Buses as BusResource;
use App\Http\Resources\Routes as RouteResource;
class Mappings extends JsonResource
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
            'bus_id' => $this->bus_id,
            'route_id' => $this->route_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'bus_data'=>BusResource::collection($this->whenLoaded('getBusRelation')),
            'route_data'=>RouteResource::collection($this->whenLoaded('getRouteRelation')),
            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
