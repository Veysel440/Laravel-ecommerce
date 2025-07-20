<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStatusUpdateRequest;
use App\Http\Resources\OrderResource;
use App\Services\Admin\AdminOrderServiceInterface;
use App\Helpers\ApiResponse;

class AdminOrderController extends Controller
{
    protected $adminOrderService;

    public function __construct(AdminOrderServiceInterface $adminOrderService)
    {
        $this->adminOrderService = $adminOrderService;
    }

    public function index()
    {
        $orders = $this->adminOrderService->listAllOrders();
        return ApiResponse::success(OrderResource::collection($orders), 'Tüm siparişler listelendi.');
    }

    public function show($id)
    {
        $order = $this->adminOrderService->getOrderDetail($id);

        if (!$order) {
            return ApiResponse::error('Sipariş bulunamadı.', 404);
        }

        return ApiResponse::success(new OrderResource($order), 'Sipariş detayı getirildi.');
    }

    public function updateStatus(OrderStatusUpdateRequest $request, $id)
    {
        $order = $this->adminOrderService->updateOrderStatus($id, $request->validated()['status']);

        return ApiResponse::success(new OrderResource($order), 'Sipariş durumu güncellendi.');
    }

    public function destroy($id)
    {
        $this->adminOrderService->deleteOrder($id);

        return ApiResponse::success(null, 'Sipariş başarıyla silindi.');
    }
}
