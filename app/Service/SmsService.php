<?php


namespace App\Service;


use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class SmsService
{
    public static function sendMessages($PhoneNumbers = 18523269519)
    {
        AlibabaCloud::accessKeyClient(env('ACCESS_KEY_ID'), env('ACCESS_SECRET'))
            ->regionId('cn-hangzhou')
            ->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'SignName' => "Yolver",
                        'PhoneNumbers' => $PhoneNumbers,
                        'TemplateCode' => "SMS_191800365",
                        'TemplateParam' => json_encode(['code'=>mt_rand(100000,999999)]),
                    ],
                ])
                ->request();
            print_r($result->toArray());
        } catch (ClientException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        } catch (ServerException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
        }
    }
}
