<?php

namespace App\Services\Campaign;

use App\Repositories\Campaign\CampaignRepositoryInterface;

class CampaignService implements CampaignServiceInterface
{
    protected $campaignRepository;

    public function __construct(CampaignRepositoryInterface $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
    }

    public function list() { return $this->campaignRepository->all(); }
    public function get($id) { return $this->campaignRepository->find($id); }
    public function create(array $data) { return $this->campaignRepository->create($data); }
    public function update($id, array $data) { return $this->campaignRepository->update($id, $data); }
    public function delete($id) { return $this->campaignRepository->delete($id); }
    public function activate($id) { return $this->campaignRepository->activate($id); }
    public function deactivate($id) { return $this->campaignRepository->deactivate($id); }
}
