<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusSchedule extends Model
{
    protected $fillable = ['id','route_id','direction','start_timestamp','end_timestamp'];

    //get route relation
    public function routeRelation()
    {
        return $this->hasMany('App\Route','id','route_id');
    }
}
