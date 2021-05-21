<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusSchedule extends Model
{
    protected $fillable = ['route_id','direction','start_timestamp','end_timestamp'];
}
