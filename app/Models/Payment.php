<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id','provider','reference','status','amount_minor','currency','raw_response'];
    protected $casts = ['raw_response'=>'encrypted:array','amount_minor'=>'integer'];
    public function order(){ return $this->belongsTo(Order::class); }
    public function refunds(){ return $this->hasMany(Refund::class); }
}
