<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\ProductIndexRequest;
use App\Http\Resources\ProductResource;
use App\Services\Catalog\ProductService;

class ProductController extends Controller
{
    public function __construct(private ProductService $svc) {}

    public function index(ProductIndexRequest $req)
    {
        $page = $this->svc->paginate($req->validated());
        return ProductResource::collection($page)
            ->additional(['success'=>true]);
    }

    public function show(string $slug)
    {
        $p = $this->svc->showBySlug($slug);
        return response()->json(['success'=>true,'data'=> new ProductResource($p)]);
    }
}
