<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Meilisearch\Client;

class SearchSync extends Command
{
    protected $signature = 'search:sync';
    protected $description = 'Meilisearch index ayarlarını senkronize et';

    public function handle(): int
    {
        $client = new Client(config('scout.meilisearch.host'), config('scout.meilisearch.key'));
        $idx = $client->index('products');

        $idx->updateSearchableAttributes(['name','description','brand_name','categories']);
        $idx->updateFilterableAttributes(['brand_id','brand_name','categories','category_ids','status','price_min_minor','price_max_minor']);
        $idx->updateSortableAttributes(['price_min_minor','price_max_minor','created_at']);
        $idx->updateRankingRules([
            'words','typo','proximity','attribute','exactness',
            'desc(created_at)'
        ]);

        $this->info('products index synced.');
        return self::SUCCESS;
    }
}
