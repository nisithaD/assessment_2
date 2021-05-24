<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusScheduleBooking extends Model
{
    protected $fillable = ['bus_seat_id','user_id','bus_schedule_id','status'];

    //get user relation
    public function getUserRelation()
    {
        return $this->hasOne('App\User','id','user_id');
    }

    //get bus schedule relation
    public function getBusScheduleRelation()
    {
        return $this->hasMany('App\BusSchedule','id','bus_schedule_id');
    }

    //get bus seat relation
    public function getBusSeatRelation()
    {
        return $this->hasMany('App\BusSeat','id','bus_seat_id');
    }
}
