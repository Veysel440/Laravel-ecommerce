<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Shipping\ShippingServiceInterface;
use App\Http\Resources\ShippingCompanyResource;

class AdminShippingController extends Controller
{
    protected $shippingService;

    public function __construct(ShippingServiceInterface $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    public function index()
    {
        return ShippingCompanyResource::collection($this->shippingService->list());
    }

    public function show($id)
    {
        $shipping = $this->shippingService->get($id);
        return new ShippingCompanyResource($shipping);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive'
        ]);
        $shipping = $this->shippingService->create($data);
        return new ShippingCompanyResource($shipping);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string',
            'cost' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|required|in:active,inactive'
        ]);
        $shipping = $this->shippingService->update($id, $data);
        return new ShippingCompanyResource($shipping);
    }

    public function destroy($id)
    {
        $this->shippingService->delete($id);
        return response()->json(['message' => 'Shipping company deleted.']);
    }
}
