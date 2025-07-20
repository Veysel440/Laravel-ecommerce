<?php

namespace App\Services\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminProductService implements AdminProductServiceInterface
{
    public function listAllProducts()
    {
        try {
            return Product::all();
        } catch (\Throwable $e) {
            Log::error('Ürün listesi alınırken hata.', ['error' => $e->getMessage()]);
            throw new Exception('Ürün listesi alınamadı.');
        }
    }

    public function createProduct(array $data)
    {
        try {
            return Product::create($data);
        } catch (\Throwable $e) {
            Log::error('Ürün eklenirken hata.', [
                'data'  => $data,
                'error' => $e->getMessage(),
            ]);
            throw new Exception('Ürün eklenemedi.');
        }
    }

    public function updateProduct(int $productId, array $data)
    {
        try {
            $product = Product::findOrFail($productId);
            $product->update($data);
            return $product;
        } catch (\Throwable $e) {
            Log::error('Ürün güncellenirken hata.', [
                'product_id' => $productId,
                'error'      => $e->getMessage(),
            ]);
            throw new Exception('Ürün güncellenemedi.');
        }
    }

    public function deleteProduct(int $productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $product->delete();
            return true;
        } catch (\Throwable $e) {
            Log::error('Ürün silinirken hata.', [
                'product_id' => $productId,
                'error'      => $e->getMessage(),
            ]);
            throw new Exception('Ürün silinemedi.');
        }
    }
}
