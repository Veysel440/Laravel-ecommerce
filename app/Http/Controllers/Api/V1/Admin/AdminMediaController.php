<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MediaUploadRequest;
use App\Models\Media;
use App\Services\Media\MediaService;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
class AdminMediaController extends Controller
{
    public function __construct(private MediaService $svc) { $this->middleware('permission:media.manage'); }

    public function store(MediaUploadRequest $r)
    {
        $files = $r->file('files', []);
        $items = $this->svc->storeMany($files, $r->user()?->id);

        return ApiResponse::ok(collect($items)->map(fn($m)=>[
            'id'=>$m->id,
            'url'=> $m->url(),
            'mime'=>$m->mime,
            'size'=>$m->size,
            'width'=>$m->width,
            'height'=>$m->height,
            'variants'=> collect($m->variants ?? [])->map(fn($p)=> \Storage::disk($m->disk)->url($p)),
        ]), 201);
    }

    public function destroy(Request $r)
    {
        $id = (int) $r->input('id');
        $m = Media::findOrFail($id);
        $this->svc->delete($m);
        return ApiResponse::ok();
    }

}
