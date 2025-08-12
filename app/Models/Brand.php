<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model {
    protected $fillable=['name','slug','meta'];
    protected $casts=['meta'=>'array'];
    public function products(){ return $this->hasMany(Product::class); }
}
