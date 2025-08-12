<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class HealthController
{
    public function __invoke()
    {
        $db = false; $cache = false;
        try { DB::select('select 1'); $db = true; } catch (\Throwable) {}
        try { Cache::put('health_ping','1', 60); $cache = Cache::get('health_ping') === '1'; } catch (\Throwable) {}
        return response()->json(['success'=>true,'data'=>[
            'time'=>now()->toISOString(),
            'version'=>app()->version(),
            'db'=>$db,'cache'=>$cache,
        ]], $db && $cache ? 200 : 503);
    }
}
