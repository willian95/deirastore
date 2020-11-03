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

    'google' => [
        'client_id' => '270786535137-mjk7uaasr6if9akf1k2ij717v2t7tir7.apps.googleusercontent.com',
        'client_secret' => 'b-reLU0CgAtW522U4H7qmfUL',
        'redirect' => 'https://deirastore.cl/auth/google/callback',
    ],

    'facebook' => [
        'client_id' => '761199804725004',
        'client_secret' => 'af57037205552a6e6fe8487a8bd975be',
        'redirect' => 'https://deirastore.cl/auth/facebook/callback',
    ],

];
