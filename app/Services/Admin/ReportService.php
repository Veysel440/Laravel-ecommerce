<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;

class ReportService
{
    public function sales(string $from, string $to, string $granularity='day'): array
    {
        $dateExpr = match($granularity) {
            'month' => "DATE_FORMAT(o.created_at,'%Y-%m-01')",
            'week'  => "STR_TO_DATE(CONCAT(YEARWEEK(o.created_at,3),' Monday'), '%X%V %W')",
            default => "DATE(o.created_at)",
        };
        $rows = DB::table('orders as o')
            ->join('order_items as oi','oi.order_id','=','o.id')
            ->selectRaw("$dateExpr as bucket, COUNT(DISTINCT o.id) as orders, SUM(oi.total) as revenue, SUM(oi.qty) as units")
            ->whereBetween('o.created_at', [$from, $to])
            ->whereIn('o.status',['paid','shipped','completed'])
            ->groupBy('bucket')
            ->orderBy('bucket')
            ->get();
        return ['items'=>$rows];
    }

    public function topProducts(string $from, string $to, int $limit=10): array
    {
        $rows = DB::table('order_items as oi')
            ->join('orders as o','o.id','=','oi.order_id')
            ->join('skus as s','s.id','=','oi.sku_id')
            ->join('products as p','p.id','=','s.product_id')
            ->selectRaw('p.id, p.name, SUM(oi.qty) as units, SUM(oi.total) as revenue')
            ->whereBetween('o.created_at', [$from, $to])
            ->whereIn('o.status',['paid','shipped','completed'])
            ->groupBy('p.id','p.name')
            ->orderByDesc('units')
            ->limit($limit)->get();
        return ['items'=>$rows];
    }

    public function stockAlerts(int $threshold=5): array
    {
        $rows = DB::table('inventories as i')
            ->join('skus as s','s.id','=','i.sku_id')
            ->join('products as p','p.id','=','s.product_id')
            ->selectRaw('p.id as product_id, p.name, s.id as sku_id, s.code, (i.qty - i.reserved_qty) as available')
            ->whereRaw('(i.qty - i.reserved_qty) < ?', [$threshold])
            ->orderBy('available')->get();
        return ['items'=>$rows];
    }

    public function coupons(string $from, string $to): array
    {
        $rows = DB::table('orders as o')
            ->selectRaw("COUNT(*) as orders, SUM(JSON_EXTRACT(totals,'$.discount')) as total_discount, SUM(JSON_EXTRACT(totals,'$.grand')) as grand")
            ->whereBetween('o.created_at', [$from,$to])
            ->get();
        return ['summary'=>$rows->first()];
    }
}
