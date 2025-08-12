<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model {
    protected $fillable=['product_id','code','price','compare_at_price','currency','weight','dimensions'];
    protected $casts=['price'=>'decimal:2','compare_at_price'=>'decimal:2','dimensions'=>'array','weight'=>'decimal:3'];
    public function product(){ return $this->belongsTo(Product::class); }
    public function optionValues(){ return $this->belongsToMany(ProductOptionValue::class,'sku_option_values'); }
    public function inventory(){ return $this->hasOne(Inventory::class); }
}
