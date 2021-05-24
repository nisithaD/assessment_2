<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusSeat extends Model
{
    protected $fillable = ['bus_id','seat_number','price'];

    //get bus relation
    public function getBusRelation()
    {
        return $this->hasMany('App\Bus','id','bus_id');
    }
}
