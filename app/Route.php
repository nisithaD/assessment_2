<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = ['id','node_one', 'node_two', 'route_number', 'distance'];

}

