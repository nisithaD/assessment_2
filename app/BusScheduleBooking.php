<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusScheduleBooking extends Model
{
    protected $fillable = ['bus_seat_id','user_id','bus_schedule_id','seat_number','price','status'];
}
