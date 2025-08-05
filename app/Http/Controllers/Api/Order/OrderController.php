<?php

namespace App\Http\Controllers\Api\Order;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use App\Services\Order\OrderServiceInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $orders = $this->orderService->getUserOrders($userId);

        return ApiResponse::success(OrderResource::collection($orders), 'Siparişler başarıyla listelendi.');
    }

    public function store(OrderStoreRequest $request)
    {
        $userId = $request->user()->id;
        $validated = $request->validated();

        $order = $this->orderService->createOrder(
            $userId,
            $validated['total_price'],
            $validated['items']
        );

        return ApiResponse::success(new OrderResource($order), 'Sipariş başarıyla oluşturuldu.', 201);
    }

    public function show($id)
    {
        $order = $this->orderService->getOrderById($id);

        if (!$order) {
            return ApiResponse::error('Sipariş bulunamadı.', 404);
        }

        return ApiResponse::success(new OrderResource($order), 'Sipariş detayları getirildi.');
    }

    public function pay($id)
    {
        $order = $this->orderService->getOrderById($id);

        if (!$order) {
            return ApiResponse::error('Sipariş bulunamadı.', 404);
        }

        if ($order->status === 'completed') {
            return ApiResponse::error('Sipariş zaten tamamlanmış.', 400);
        }

        $order->status = 'completed';
        $order->save();

        return ApiResponse::success(new OrderResource($order), 'Sipariş ödemesi tamamlandı.');
    }
}
