<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable=['user_id','number','status','currency','totals','billing_address','shipping_address'];
    protected $casts=['totals'=>'array','billing_address'=>'array','shipping_address'=>'array'];
    public function items(){ return $this->hasMany(OrderItem::class); }
    public function user(){ return $this->belongsTo(User::class); }
    public function payments(){ return $this->hasMany(Payment::class); }
}
