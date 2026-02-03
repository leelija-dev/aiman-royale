<?php

return [
    'app_id' => env('CASHFREE_APP_ID'),
    'secret_key' => env('CASHFREE_SECRET_KEY'),
    'environment' => env('CASHFREE_ENVIRONMENT', 'sandbox'),
    'return_url' => env('CASHFREE_RETURN_URL'),
    'webhook_url' => env('CASHFREE_WEBHOOK_URL'),
    'api_version' => '2023-08-01',
];