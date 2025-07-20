<?php

namespace App\Services\Admin;

interface AdminProductServiceInterface
{
    public function listAllProducts();
    public function createProduct(array $data);
    public function updateProduct(int $productId, array $data);
    public function deleteProduct(int $productId);

}
