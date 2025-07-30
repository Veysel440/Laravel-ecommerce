<?php

namespace App\Repositories\Campaign;

use App\Models\Campaign;

class CampaignRepository implements CampaignRepositoryInterface
{
    public function all() { return Campaign::all(); }
    public function find($id) { return Campaign::findOrFail($id); }
    public function create(array $data) { return Campaign::create($data); }
    public function update($id, array $data) {
        $campaign = Campaign::findOrFail($id);
        $campaign->update($data);
        return $campaign;
    }
    public function delete($id) {
        $campaign = Campaign::findOrFail($id);
        $campaign->delete();
        return true;
    }
    public function activate($id) {
        $campaign = Campaign::findOrFail($id);
        $campaign->status = 'active';
        $campaign->save();
        return $campaign;
    }
    public function deactivate($id) {
        $campaign = Campaign::findOrFail($id);
        $campaign->status = 'inactive';
        $campaign->save();
        return $campaign;
    }
}
