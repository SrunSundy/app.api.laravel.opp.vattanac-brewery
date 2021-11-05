<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'vb_cipher' => [
        'password' => '4EuvVktDGWOmbiPXgYm4DWYtGZ9YfMzS', // 32 byte
        'iv' => 'r2xl5zEUfCInSsdx', // 16 byte
    ],

    'telegram' => [
        'base_url' => 'https://api.telegram.org',
        'token' => env('TELEGRAM_BOT_TOKEN', false),
        'path' => 'sendMessage',
        'chat_id' => env('TELEGRAM_CHAT_ID', false),
        'log_channel' => env('TELEGRAM_LOG_CHANNEL', '-690227300'),
    ],
];
