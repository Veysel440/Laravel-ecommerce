<?php

namespace App\Services\Catalog;

use App\Models\Category;

class CategoryService
{
    public function list(): \Illuminate\Support\Collection
    {
        return Category::with('children')->where('status','active')->whereNull('parent_id')->get();
    }

    public function findBySlug(string $slug): Category
    {
        return Category::with(['children','products'=>function($q){ $q->where('status','active'); }])
            ->where('slug',$slug)->firstOrFail();
    }
}
