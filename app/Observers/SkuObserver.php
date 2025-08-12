<?php

namespace App\Observers;

use App\Models\Inventory;
use App\Models\Sku;

class SkuObserver
{
    public function created(Sku $sku): void
    {
        Inventory::firstOrCreate(['sku_id'=>$sku->id], ['qty'=>0,'reserved_qty'=>0]);
    }
}
