<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Buses extends JsonResource
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
            'name' => $this->name,
            'type' => $this->type,
            'vehicle_number' => $this->vehicle_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'links' => [
                'self' => 'link-value',
            ],
        ];
    }
}
