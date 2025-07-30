<?php

namespace App\Repositories\Shipping;

use App\Models\ShippingCompany;

class ShippingRepository implements ShippingRepositoryInterface
{
    public function all()
    {
        return ShippingCompany::all();
    }

    public function find($id)
    {
        return ShippingCompany::findOrFail($id);
    }

    public function create(array $data)
    {
        return ShippingCompany::create($data);
    }

    public function update($id, array $data)
    {
        $shipping = ShippingCompany::findOrFail($id);
        $shipping->update($data);
        return $shipping;
    }

    public function delete($id)
    {
        $shipping = ShippingCompany::findOrFail($id);
        $shipping->delete();
        return true;
    }
}
