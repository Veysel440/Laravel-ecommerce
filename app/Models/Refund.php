<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = ['order_id','payment_id','provider','reference','amount_minor','currency','status','raw'];
    protected $casts = ['raw'=>'encrypted:array','amount_minor'=>'integer'];
    public function order(){ return $this->belongsTo(Order::class); }
    public function payment(){ return $this->belongsTo(Payment::class); }
}
