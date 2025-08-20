<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'user_id','disk','path','original_name','mime','size','width','height','checksum','variants',
    ];
    protected $casts = ['variants'=>'array'];

    public function url(): string
    {
        $disk = \Storage::disk($this->disk);
        if (method_exists($disk->getDriver(), 'temporaryUrl')) {
            return $disk->temporaryUrl($this->path, now()->addSeconds((int) config('media.temporary_url_ttl')));
        }
        return $disk->url($this->path);
    }
}
