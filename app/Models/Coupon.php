<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'discount', 'valid_from', 'valid_until', 'type', 'usage_limit', 'used'
    ];
}
