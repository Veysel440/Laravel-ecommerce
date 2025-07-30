<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'title', 'description', 'discount_rate', 'start_date', 'end_date', 'status'
    ];
}
