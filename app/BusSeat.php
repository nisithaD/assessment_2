<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusSeat extends Model
{
    protected $fillable = ['bus_id','seat_number','price'];
}
