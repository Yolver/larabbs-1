<?php

namespace App\Http\Controllers;

use App\Service\SmsService;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function send()
    {
        SmsService::sendMessages();

        return response()->json([
            'status' => 'ok',
            'message' => 'send message success'
        ]);
    }
}
