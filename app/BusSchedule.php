<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusSchedule extends Model
{
    protected $fillable = ['route_id','direction','start_timestamp','end_timestamp'];

    //get Route relation
    public function getRouteRelation()
    {
        return $this->hasOne('App\Route','id','route_id');
    }
}
