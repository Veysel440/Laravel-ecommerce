<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;

class CategoryController extends Controller {
    public function __construct()
    {
        $this->middleware('permission:catalog.manage');
    }
    public function index()
    {
        return \App\Models\Category::with('parent')->latest()->paginate(20);
    }
    public function store(\App\Http\Requests\Admin\CategoryStoreRequest $r){
        $data = $r->validated(); $data['slug'] = $data['slug'] ?? \Illuminate\Support\Str::slug($data['name']);
        $c = \App\Models\Category::create($data); return response()->json(['success'=>true,'data'=>$c],201);
    }
    public function update(\App\Models\Category $category, \App\Http\Requests\Admin\CategoryUpdateRequest $r){
        $category->update($r->validated()); return ['success'=>true,'data'=>$category];
    }
    public function destroy(\App\Models\Category $category)
    {
        $category->delete(); return ['success'=>true];
    }
}
