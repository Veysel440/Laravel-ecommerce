<?php

namespace App\Services\Shipping;

use App\Repositories\Shipping\ShippingRepositoryInterface;

class ShippingService implements ShippingServiceInterface
{
    protected $shippingRepository;

    public function __construct(ShippingRepositoryInterface $shippingRepository)
    {
        $this->shippingRepository = $shippingRepository;
    }

    public function list()
    {
        return $this->shippingRepository->all();
    }

    public function get($id)
    {
        return $this->shippingRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->shippingRepository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->shippingRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->shippingRepository->delete($id);
    }
}
