<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model {
    protected $fillable=['actor_id','action','subject_type','subject_id','payload'];
    protected $casts=['payload'=>'array'];
    public function actor(){ return $this->belongsTo(User::class,'actor_id'); }
}
