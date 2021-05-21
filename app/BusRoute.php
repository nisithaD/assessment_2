<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusRoute extends Model
{
    protected $fillable = ['bus_id','route_id','status'];

    //get bus relation
    public function getBusRelation()
    {
        return $this->hasMany('App\Bus','id','bus_id');
    }

    //get route relation
    public function getRouteRelation()
    {
        return $this->hasOne('App\Route','id','route_id');
    }
}
