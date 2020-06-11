<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public $table = "packages";
    protected $fillable = [ 'package_name', 'package_cost', 'package_description' ];
}
