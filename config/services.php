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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'cashfree' => [
        'test_mode' => env('CASHFREE_TEST_MODE', true),
        'test_app_id' => env('CASHFREE_TEST_APP_ID'),
        'test_secret_key' => env('CASHFREE_TEST_SECRET_KEY'),
        'app_id' => env('CASHFREE_APP_ID'),
        'secret_key' => env('CASHFREE_SECRET_KEY'),
        'environment' => env('CASHFREE_ENVIRONMENT', 'sandbox'),
        'return_url' => env('CASHFREE_RETURN_URL'),
        'webhook_url' => env('CASHFREE_WEBHOOK_URL'),
    ],

    'delhivery' => [
        'api_key' => env('DELHIVERY_API_KEY'),
        'sandbox' => env('DELHIVERY_SANDBOX', true),
        'pickup_location' => env('DELHIVERY_PICKUP_LOCATION', 'Default Warehouse'),
        'pickup_pincode' => env('DELHIVERY_PICKUP_PINCODE', '110001'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'social' => [
        'facebook' => env('FACEBOOK_LINK'),
        'instagram' => env('INSTA_LINK'),
        'youtube' => env('SOCIAL_YOUTUBE_URL'),
        'twitter' => env('X_LINK'),
        'linkedin' => env('LINKEDIN_LINK'),
    ],

];
