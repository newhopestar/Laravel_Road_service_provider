<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   public  $table = "orders";
   protected $fillable = ['user_id', 'order_date', 'package_id', 'service_period', 'expiration_date', 'notes'];
   public $timestamps =  false;

   public function user() {
       return $this->belongsTo('App\User', 'user_id', 'id');
   }

   public function package(){
       return $this->belongsTo('App\Package', 'package_id', 'id');
   }
}
