<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\VerificationCodeRequest;
use App\Service\SmsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class VerificationCodesController extends Controller
{
    public function store(VerificationCodeRequest $request)
    {
        $captchaData = Cache::get($request->captcha_key);
        if (!$captchaData){
            return response()->json([
                'message' => '图片验证码已失效'
            ], 422);
        }

        if (!hash_equals($captchaData['code'],$request->captcha_code)){
            Cache::forget($request->captcha_key);
            return response()->json([
                'message' => '验证码错误'
            ], 401);
        }

        $phoneNumbers = $captchaData['phone'];

        if (!app()->environment('production')){
            $code = '123456';
        }else{
            $code = mt_rand(100000,999999);

            $sms = new SmsService();
            $sms->sendMessages($phoneNumbers, $code);
        }

        $key = 'verificationCode_' . str_random(15);
        $expiredAt = now()->addMinutes(10);

        Cache::put($key, ['phone' => $phoneNumbers, 'code' => $code], $expiredAt);

        Cache::forget($request->captcha_key);

        return response()->json([
            'key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
        ], 201);
    }
}
