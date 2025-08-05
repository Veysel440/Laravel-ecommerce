<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminReportServiceInterface;
use App\Helpers\ApiResponse;

class AdminReportController extends Controller
{
    protected $adminReportService;

    public function __construct(AdminReportServiceInterface $adminReportService)
    {
        $this->adminReportService = $adminReportService;
    }

    public function summary()
    {
        $data = $this->adminReportService->summary();
        return ApiResponse::success($data, 'Rapor özeti getirildi.');
    }

    public function totalSales()
    {
        $sales = $this->adminReportService->totalSales();
        return ApiResponse::success(['total_sales' => $sales], 'Toplam satış getirildi.');
    }

    public function totalOrders()
    {
        $orders = $this->adminReportService->totalOrders();
        return ApiResponse::success(['total_orders' => $orders], 'Toplam sipariş sayısı getirildi.');
    }

    public function totalUsers()
    {
        $users = $this->adminReportService->totalUsers();
        return ApiResponse::success(['total_users' => $users], 'Toplam kullanıcı sayısı getirildi.');
    }
}
