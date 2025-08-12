<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {
    protected $casts = [
        'is_default'=>'boolean',
        'phone'=>'encrypted:string',
    ];
    protected $fillable = ['user_id','type','full_name','phone','line1','line2','city','state','postal_code','country','is_default'];
    public function user(){ return $this->belongsTo(User::class); }
}
