<?php

namespace App\Repositories\Campaign;


interface CampaignRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function activate($id);
    public function deactivate($id);
}
