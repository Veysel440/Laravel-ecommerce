<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Services\Admin\AdminProductServiceInterface;

class AdminProductController extends Controller
{
    protected $adminProductService;

    public function __construct(AdminProductServiceInterface $adminProductService)
    {
        $this->adminProductService = $adminProductService;
    }

    public function index()
    {
        $products = $this->adminProductService->listAllProducts();
        return ApiResponse::success(ProductResource::collection($products), 'Ürün listesi getirildi.');
    }

    public function store(ProductStoreRequest $request)
    {
        $product = $this->adminProductService->createProduct($request->validated());
        return ApiResponse::success(new ProductResource($product), 'Ürün başarıyla eklendi.', 201);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $product = $this->adminProductService->updateProduct($id, $request->validated());
        return ApiResponse::success(new ProductResource($product), 'Ürün başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $this->adminProductService->deleteProduct($id);
        return ApiResponse::success(null, 'Ürün başarıyla silindi.');
    }
}
