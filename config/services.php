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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google'=>[
        'client_id' => '1000939671997-d7ps7vp8btvvvo3qpldqpcet8ra31359.apps.googleusercontent.com',
        'client_secret' => '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',
        'redirect' => 'http://127.0.0.1:8000/auth/google/callback',
    ],
    'facebook'=>[
        'client_id' => '3841335436123346',
        'client_secret' => '3c55fcaf488b519eb21714a046fba441',
        'redirect' => 'http://127.0.0.1:8000/auth/facebook/callback',
    ],


];
