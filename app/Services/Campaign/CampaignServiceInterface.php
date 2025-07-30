<?php

namespace App\Services\Campaign;


interface CampaignServiceInterface
{
    public function list();
    public function get($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function activate($id);
    public function deactivate($id);
}
