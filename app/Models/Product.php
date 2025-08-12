<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    protected $fillable=['brand_id','name','slug','description','status','tax_rate','meta'];
    protected $casts=['meta'=>'array','tax_rate'=>'decimal:2'];
    public function brand(){ return $this->belongsTo(Brand::class); }
    public function categories(){ return $this->belongsToMany(Category::class); }
    public function images(){ return $this->hasMany(ProductImage::class); }
    public function options(){ return $this->hasMany(ProductOption::class); }
    public function skus(){ return $this->hasMany(Sku::class); }
    public function reviews(){ return $this->hasMany(Review::class); }
}
