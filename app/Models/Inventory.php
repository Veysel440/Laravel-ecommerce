<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model {
    protected $fillable=['sku_id','qty','reserved_qty'];
    public function sku(){ return $this->belongsTo(Sku::class); }
}
