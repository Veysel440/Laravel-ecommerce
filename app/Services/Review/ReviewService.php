<?php

namespace App\Services\Review;

use App\Exceptions\DomainStateException;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class ReviewService
{
    public function create(int $userId, int $productId, int $rating, ?string $body): Review
    {
        if (!$this->isVerifiedPurchase($userId, $productId)) {
            throw new DomainStateException('not_verified_purchase');
        }
        return Review::create([
            'user_id'=>$userId,'product_id'=>$productId,'rating'=>$rating,'body'=>$body,'status'=>'pending',
        ]);
    }

    public function update(Review $review, array $data): Review
    {
        $review->update($data);
        $review->status = 'pending'; // yeniden moderasyon
        $review->save();
        return $review;
    }

    private function isVerifiedPurchase(int $userId, int $productId): bool
    {
        return DB::table('orders as o')
            ->join('order_items as oi','oi.order_id','=','o.id')
            ->join('skus as s','s.id','=','oi.sku_id')
            ->where('o.user_id',$userId)
            ->where('s.product_id',$productId)
            ->whereIn('o.status',['paid','shipped','completed'])
            ->exists();
    }
}
