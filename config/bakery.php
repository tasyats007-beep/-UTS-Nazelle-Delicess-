<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Nazelle Délices Official Payment Configurations
    |--------------------------------------------------------------------------
    | Real store configurations for QRIS and Bank Transfer.
    | If not configured (is_configured = false), checkout explicitly informs
    | customers that the method has not been configured yet, without
    | generating fake or dummy banking data.
    */
    'qris' => [
        'is_configured' => env('BAKERY_QRIS_CONFIGURED', false),
        'image_url' => env('BAKERY_QRIS_IMAGE_URL', null),
        'merchant_name' => env('BAKERY_QRIS_MERCHANT_NAME', null),
        'nmid' => env('BAKERY_QRIS_NMID', null),
    ],

    'bank_transfer' => [
        'is_configured' => env('BAKERY_BANK_CONFIGURED', false),
        'bank_name' => env('BAKERY_BANK_NAME', null),
        'account_number' => env('BAKERY_BANK_ACCOUNT_NUMBER', null),
        'account_holder' => env('BAKERY_BANK_ACCOUNT_HOLDER', null),
    ],
];
