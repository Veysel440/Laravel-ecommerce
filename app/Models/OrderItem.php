<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model {
    protected $fillable=['order_id','sku_id','qty','unit_price_minor','tax_minor','total_minor'];
    protected $casts=['unit_price_minor'=>'integer','tax_minor'=>'integer','total_minor'=>'integer'];
    public function getUnitPriceAttribute(): string { return \App\Support\Money::fromMinor($this->unit_price_minor, $this->order->currency); }
    public function getTaxAttribute(): string { return \App\Support\Money::fromMinor($this->tax_minor, $this->order->currency); }
    public function getTotalAttribute(): string { return \App\Support\Money::fromMinor($this->total_minor, $this->order->currency); }
}
