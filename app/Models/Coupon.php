<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model {
    protected $fillable=['code','type','value','starts_at','ends_at','usage_limit','used_count'];
    protected $casts=['value'=>'decimal:2','starts_at'=>'datetime','ends_at'=>'datetime'];
}
