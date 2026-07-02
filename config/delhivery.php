<?php

return [
    'api_token' => env('DELHIVERY_API_TOKEN'),
    'pickup_location' => env('DELHIVERY_PICKUP_LOCATION'),
    'sandbox_url' => env('DELHIVERY_SANDBOX_URL', 'https://staging-express.delhivery.com'),
    'production_url' => env('DELHIVERY_PRODUCTION_URL', 'https://express.delhivery.com'),
    'mode' => env('DELHIVERY_MODE', 'sandbox'), // sandbox or production
    'packing_slip_api_url' => env('DELHIVERY_PACKING_SLIP_API_URL', 'https://staging-express.delhivery.com/api/p/packing_slip'),
];