<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;

class ReportController extends Controller {
    public function __construct(private \App\Services\Admin\ReportService $svc)
    {
        $this->middleware('permission:orders.view');
    }
    public function sales()
    {
        return ['success'=>true,'data'=> $this->svc->sales(request('from'),
            request('to'), request('granularity','day'))];
    }
    public function topProducts()
    {
        return ['success'=>true,'data'=> $this->svc->topProducts(request('from'),
            request('to'), (int)request('limit',10))];
    }
    public function stockAlerts()
    {
        return ['success'=>true,'data'=> $this->svc->stockAlerts((int)request('threshold',5))];
    }
    public function coupons(){
        return ['success'=>true,'data'=> $this->svc->coupons(request('from'),
            request('to'))];
    }
    public function snapshot(\Illuminate\Contracts\Cache\Repository $cache)
    {
        $data = $cache->get('dash:sales:current_month');
        return ['success'=>true,'data'=>$data];
    }
}
