<?php

namespace App\Services\Admin;

interface AdminReportServiceInterface
{
    public function totalSales();
    public function totalOrders();
    public function totalUsers();
    public function summary();

}
