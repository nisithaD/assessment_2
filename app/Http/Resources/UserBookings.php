<?php

namespace App\Http\Resources;

use App\BusSchedule;
use App\Route;
use Illuminate\Http\Resources\Json\JsonResource;

class UserBookings extends JsonResource
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
            'id'=>$this->id,
            'bus_seat_id'=>$this->bus_seat_id,
            'user_id'=>$this->user_id,
            'bus_schedule_id'=>$this->bus_schedule_id,
            'status'=>$this->status,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,

            //need to develeop
            'seat_data'=>Seats::collection($this->whenLoaded('getBusSeatRelation')),
            'bus_schedule_data'=>Schedules::collection($this->whenLoaded('getBusScheduleRelation')),
            'bus_route_data'=>Routes::collection($this->whenLoaded('getRouteRelation'))

        ];
    }
}
