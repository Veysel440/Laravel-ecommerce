<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\Catalog\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $svc) {}

    public function index()
    {
        $items = $this->svc->list();
        return response()->json(['success'=>true,'data'=> CategoryResource::collection($items)]);
    }

    public function show(string $slug)
    {
        $cat = $this->svc->findBySlug($slug);
        return response()->json(['success'=>true,'data'=> new CategoryResource($cat)]);
    }
}
