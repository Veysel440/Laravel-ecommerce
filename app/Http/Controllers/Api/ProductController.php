<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Services\Product\ProductServiceInterface;
use App\Helpers\ApiResponse;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getAllProducts();
        return ApiResponse::success(ProductResource::collection($products), 'Tüm ürünler listelendi.');
    }

    public function store(ProductStoreRequest $request)
    {
        $product = $this->productService->createProduct($request->validated());
        return ApiResponse::success(new ProductResource($product), 'Ürün başarıyla eklendi.', 201);
    }

    public function show($id)
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            return ApiResponse::error('Ürün bulunamadı.', 404);
        }

        return ApiResponse::success(new ProductResource($product), 'Ürün detayları getirildi.');
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $result = $this->productService->updateProduct($id, $request->validated());

        if (!$result) {
            return ApiResponse::error('Ürün bulunamadı.', 404);
        }

        $product = $this->productService->getProductById($id);
        return ApiResponse::success(new ProductResource($product), 'Ürün başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $result = $this->productService->deleteProduct($id);

        if (!$result) {
            return ApiResponse::error('Ürün bulunamadı.', 404);
        }

        return ApiResponse::success(null, 'Ürün başarıyla silindi.');
    }
}
