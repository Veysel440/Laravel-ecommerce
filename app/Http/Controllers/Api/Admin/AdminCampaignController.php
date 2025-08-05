<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Campaign\CampaignServiceInterface;
use App\Http\Resources\CampaignResource;

class AdminCampaignController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignServiceInterface $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    public function index()
    {
        return CampaignResource::collection($this->campaignService->list());
    }

    public function show($id)
    {
        $campaign = $this->campaignService->get($id);
        return new CampaignResource($campaign);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'discount_rate' => 'required|numeric|min:0|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $campaign = $this->campaignService->create($data);
        return new CampaignResource($campaign);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'discount_rate' => 'sometimes|required|numeric|min:0|max:100',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
        ]);
        $campaign = $this->campaignService->update($id, $data);
        return new CampaignResource($campaign);
    }

    public function destroy($id)
    {
        $this->campaignService->delete($id);
        return response()->json(['message' => 'Campaign deleted.']);
    }

    public function activate($id)
    {
        $campaign = $this->campaignService->activate($id);
        return new CampaignResource($campaign);
    }

    public function deactivate($id)
    {
        $campaign = $this->campaignService->deactivate($id);
        return new CampaignResource($campaign);
    }
}
