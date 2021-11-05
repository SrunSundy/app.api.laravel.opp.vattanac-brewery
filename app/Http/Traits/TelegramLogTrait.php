<?php

namespace App\Http\Traits;

use GuzzleHttp\Client as HttpClient;

trait TelegramLogTrait
{
    public function logRequestTelegram()
    {
        $base_url = config('services.telegram.base_url');
        $token = config('services.telegram.token');
        $path = config('services.telegram.path');
        $chat_id = config('services.telegram.log_channel');
        // $chat_id = "-690227300";

        if ($token) {
            $url = "$base_url/bot$token/$path?chat_id=$chat_id&text=Route : " . request()->url() . "\nRequest : " . json_encode(request()->all()) . "\nDevice : " . request()->header('Device') . "\nIP : " . request()->ip();

            $http = new HttpClient;
            $response =  $http->get($url);

            // info('Telegram:', ['data' => $response->getBody()]);
        }
    }
    public function logDataTelegram($data = [])
    {
        $base_url = config('services.telegram.base_url');
        $token = config('services.telegram.token');
        $path = config('services.telegram.path');
        $chat_id = config('services.telegram.log_channel');

        if ($token) {
            $url = "$base_url/bot$token/$path?chat_id=$chat_id&text=Route : " . request()->url() . "\Data : " . json_encode($data) . "\nDevice : " . request()->header('Device') . "\nIP : " . request()->ip();

            $http = new HttpClient;
            $response =  $http->get($url);

            // info('Telegram:', ['data' => $response->getBody()]);
        }
    }
}
