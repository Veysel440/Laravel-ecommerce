<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model {
    protected $fillable = ['product_id','code','price_minor','compare_at_price_minor','currency','weight','dimensions'];
    protected $casts = ['dimensions'=>'array','weight'=>'decimal:3'];
    public function getPriceAttribute(): string { return \App\Support\Money::fromMinor($this->price_minor, $this->currency); }
    public function getCompareAtPriceAttribute(): ?string {
        return $this->compare_at_price_minor !== null ? \App\Support\Money::fromMinor($this->compare_at_price_minor, $this->currency) : null;
    }
}
