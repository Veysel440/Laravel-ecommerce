<?php

namespace App\Http\Controllers\Api\V1\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\{AddressStoreRequest,AddressUpdateRequest};
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function index(Request $r) {
        $items = $r->user()->addresses()->orderByDesc('is_default')->latest()->get();
        return ApiResponse::ok(AddressResource::collection($items));
    }

    public function store(AddressStoreRequest $r) {
        return DB::transaction(function() use($r){
            if ($r->boolean('is_default')) {
                $r->user()->addresses()->where('type',$r->type)->update(['is_default'=>false]);
            }
            $addr = $r->user()->addresses()->create($r->validated());
            return ApiResponse::ok(new AddressResource($addr), 201);
        });
    }

    public function update(AddressUpdateRequest $r, Address $address) {
        abort_unless($address->user_id === $r->user()->id, 403);
        return DB::transaction(function() use($r,$address){
            $data = $r->validated();
            if (array_key_exists('is_default',$data) && $data['is_default']) {
                $r->user()->addresses()->where('type', $data['type'] ?? $address->type)->update(['is_default'=>false]);
            }
            $address->update($data);
            return ApiResponse::ok(new AddressResource($address));
        });
    }

    public function destroy(Request $r, Address $address) {
        abort_unless($address->user_id === $r->user()->id, 403);
        $address->delete();
        return ApiResponse::ok();
    }
}
