<?php

namespace App\Services\Product;

use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Exception;
class ProductService implements ProductServiceInterface
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts()
    {
        try {
            return $this->productRepository->all();
        } catch (\Throwable $e) {
            Log::error('Ürün listelenirken hata oluştu.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw new Exception('Ürün listelenirken bir hata oluştu.');
        }
    }

    public function getProductById(int $id)
    {
        try {
            return $this->productRepository->findById($id);
        } catch (\Throwable $e) {
            Log::error('Ürün detay getirilirken hata oluştu.', [
                'product_id' => $id,
                'error'      => $e->getMessage(),
            ]);
            throw new Exception('Ürün detay getirilirken sistem hatası oluştu.');
        }
    }

    public function createProduct(array $data)
    {
        try {
            return $this->productRepository->create($data);
        } catch (\Throwable $e) {
            Log::error('Ürün eklenirken hata oluştu.', [
                'error' => $e->getMessage(),
                'data'  => $data,
            ]);
            throw new Exception('Ürün eklenirken sistem hatası oluştu.');
        }
    }

    public function updateProduct(int $id, array $data)
    {
        try {
            return $this->productRepository->update($id, $data);
        } catch (\Throwable $e) {
            Log::error('Ürün güncellenirken hata oluştu.', [
                'product_id' => $id,
                'error'      => $e->getMessage(),
            ]);
            throw new Exception('Ürün güncellenirken sistem hatası oluştu.');
        }
    }

    public function deleteProduct(int $id)
    {
        try {
            return $this->productRepository->delete($id);
        } catch (\Throwable $e) {
            Log::error('Ürün silinirken hata oluştu.', [
                'product_id' => $id,
                'error'      => $e->getMessage(),
            ]);
            throw new Exception('Ürün silinirken sistem hatası oluştu.');
        }
    }

}
