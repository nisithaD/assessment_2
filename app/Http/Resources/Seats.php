<?php

namespace App\Http\Resources;

use App\Http\Resources\Buses as BusResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Seats extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'bus_id' => $this->bus_id,
            'seat_number' => $this->seat_number,
            'price' => $this->price,

            'bus_data'=>BusResource::collection($this->whenLoaded('getBusRelation')),
        ];
    }
}
