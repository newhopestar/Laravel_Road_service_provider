<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    public $table='vehicles';
    protected $fillable =['user_id', 'type', 'color', 'license_plate'];
    public $timestamps= false;
}
