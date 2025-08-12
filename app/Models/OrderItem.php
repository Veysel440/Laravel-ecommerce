<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    protected $fillable=['order_id','sku_id','qty','unit_price','tax','total'];
    protected $casts=['unit_price'=>'decimal:2','tax'=>'decimal:2','total'=>'decimal:2'];
    public function order(){ return $this->belongsTo(Order::class); }
    public function sku(){ return $this->belongsTo(Sku::class); }
}
