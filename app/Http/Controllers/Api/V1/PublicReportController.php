<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Cache\Repository as Cache;

class PublicReportController extends Controller
{
    public function snapshot(Cache $cache)
    {
        $data = $cache->get('dash:sales:current_month') ?? ['items'=>[]];
        return ['success'=>true,'data'=>[
            'items'=>$data['items'] ?? [],
        ]];
    }
}
