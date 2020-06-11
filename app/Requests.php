<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    public $table="requests";
    protected $fillable = ['request_date', 'completed_date', 'vehicle_id', 'service_id', 'notes', 'request_location'];
    public $timestamps= false;
    
    public function vehicle() {
        return $this->belongsTo('App\Vehicle', 'vehicle_id', 'id');
    }

    public function service(){
        return $this->belongsTo('App\Service' , 'service_id', 'id');
    }
}
