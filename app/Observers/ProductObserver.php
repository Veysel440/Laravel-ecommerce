<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function saved(Product $p): void
    {
        Cache::forget("cat:product:{$p->slug}");
        $p->shouldBeSearchable() ? $p->searchable() : $p->unsearchable();
    }

    public function deleted(Product $p): void
    {
        Cache::forget("cat:product:{$p->slug}");
        $p->unsearchable();
    }
}
