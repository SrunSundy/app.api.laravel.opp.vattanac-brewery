<?php

namespace App\Http\Traits\Twilio;

use App\Models\MessageTemplate;
use Twilio\Rest\Client;
use GuzzleHttp\Client as HttpClient;

trait TwilioSmsService
{
    /**
     * @param $phone_number
     * @param $code
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function sendSMSVerification($phone_number, $code)
    {
        if (env('TWILIO_SID', false) && env('TWILIO_TOKEN', false) && env('TWILIO_FROM', false)) {
            $message = MessageTemplate::getMessageByKey('verify_code');
            $message = $this->replaceMessage($message, [
                '[VERIFY_CODE]' => $code,
            ]);

            $this->sendSms($phone_number, $message);
        }

        if (env('IS_DEVELOPMENT', false)) {
            $message = MessageTemplate::getMessageByKey('verify_code');
            $message = $this->replaceMessage($message, [
                '[VERIFY_CODE]' => $code,
            ]);

            $this->sendSmsToTelegram($phone_number, $message);
        }
    }

    /**
     * @param $text
     * @param $data
     * @return string
     */
    protected function replaceMessage($text, $data)
    {
        return strtr($text, $data);
    }

    /**
     * Send SMS
     *
     * @param $phone_number
     * @param $message
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    private function sendSms($phone_number, $message)
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_TOKEN');
        $client = new Client($sid, $token);

        info('Send SMS to: ' . $phone_number);
        info('Send SMS Message: ' . $message);

        $response = $client->messages->create(
            $phone_number,
            [
                'from' => env('TWILIO_FROM'),
                'body' => $message,
            ]
        );

        info('Twilio Message: ' . json_encode($response));
    }

    /**
     * Send SMS to telegram group for development Purpose
     *
     * @param $phone_number
     * @param $message
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function sendSmsToTelegram($phone_number, $message)
    {
        $base_url = config('broadcasting.telegram.base_url');
        $token = config('broadcasting.telegram.token');
        $path = config('broadcasting.telegram.path');
        $chat_id = config('broadcasting.telegram.chat_id');
        $project_name = env('APP_NAME');

        $url = "$base_url/bot$token/$path?chat_id=$chat_id&text=$project_name:$phone_number=>$message";

        $http = new HttpClient;
        $request =  $http->get($url);

        info('SMS Telegram:', ['data' => $request->getBody()]);

        return;
    }
}
