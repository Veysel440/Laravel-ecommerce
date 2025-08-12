<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IyzicoWebhookController extends Controller
{
    public function __invoke(Request $r)
    {
        return response()->json(['received'=>true]);
    }
}
