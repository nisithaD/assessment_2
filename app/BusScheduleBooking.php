<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusScheduleBooking extends Model
{
    protected $fillable = ['bus_seat_id','user_id','bus_schedule_id','seat_number','price','status'];

    //get user relation
    public function getUserRelation()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    //get bus schedule relation
    public function getBusScheduleRelation()
    {
        return $this->hasOne('App\BusSchedule','id','bus_schedule_id');
    }

    //get bus seat relation
    public function getBusSeatRelation()
    {
        return $this->hasOne('App\BusSeat','id','seat_number');
    }
}
