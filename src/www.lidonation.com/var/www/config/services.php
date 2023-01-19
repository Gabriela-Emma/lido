<?php

return [

    'analytics' => [
        'id' => env('ANALYTICS_ID'),
    ],

    'fathom' => [
        'site' => env('ANALYTICS_ID'),
    ],

    'cardano-wallet' => [
        'host' => env('HOST', 'cardano-wallet'),
        'port' => env('PORT', 8090),
        'validation_seed' => 1681000,
    ],

    'cloudflare' => [
        'token' => env('CLOUDFLARE_TOKEN'),
    ],

    'coinmarketcap' => [
        'key' => env('COIN_MARKET_CAP_API_KEY'),
    ],

    'blockfrost' => [
        'projectId' => env('BLOCKFROST_PROJECT_ID'),
        'baseUrl' => env('BLOCKFROST_BASE_URL', 'https://cardano-preview.blockfrost.io/api/v0'),
    ],

    'deepl' => [
        'auth_key' => env('DEEPL_AUTH_KEY'),
    ],

    'facebook' => [
        'app_id' => env('FACEBOOK_APP_ID'),
    ],

    'catalyst' => [
        'catalyst_reporting_spreadsheet_id' => env('CATALYST_REPORTING_SPREADSHEET_ID', ''),
    ],

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

    'stripe' => [
        'key' => env('STRIPE_PK'),
        'secret' => env('STRIPE_SK'),
    ],

    'twitter' => [
        'client_id' => env('TWITTER_OAUTH_CLIENT_ID'),
        'client_secret' => env('TWITTER_OAUTH_CLIENT_SECRET'),
        'redirect' => env('TWITTER_OAUTH_CALLBACK_URL'),
    ],

    'mailchimp' => [
        'key' => env('MAILCHIMP_KEY'),
        'server' => env('MAILCHIMP_SERVER'),
        'lists' => [
            'subscribers' => env('MAILCHIMP_LIST_SUBSCRIBERS')
        ]
    ],
];
