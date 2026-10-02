<?php

return [
    'api_token' => env('DELHIVERY_API_TOKEN'),
    'pickup_location' => env('DELHIVERY_PICKUP_LOCATION'),
    'sandbox' => env('DELHIVERY_SANDBOX', true),
    'sandbox_url' => env('DELHIVERY_SANDBOX_URL', 'https://staging-express.delhivery.com'),
    'production_url' => env('DELHIVERY_PRODUCTION_URL', 'https://api.delhivery.com'),
    'mode' => env('DELHIVERY_MODE', 'sandbox'), // sandbox or production
    'packing_slip_api_url' => env('DELHIVERY_PACKING_SLIP_API_URL', 'https://api.delhivery.com/api/p/packing_slip'),

    'return_name' => env('DELHIVERY_RETURN_NAME'),
    'return_add' => env('DELHIVERY_RETURN_ADDRESS'),
    'return_city' => env('DELHIVERY_RETURN_CITY'),
    'return_state' => env('DELHIVERY_RETURN_STATE'),
    'return_pincode' => env('DELHIVERY_RETURN_PINCODE'),
    'return_phone' => env('DELHIVERY_RETURN_PHONE'),
    'return_country' => env('DELHIVERY_RETURN_COUNTRY', 'India'),
];