<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Midtrans payment gateway integration.
    | Set isProduction to true when going live.
    |
    */

    'server_key' => env('MIDTRANS_SERVER_KEY', ''),
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => true,
    'is_3ds' => true,

    /*
    |--------------------------------------------------------------------------
    | Transaction Settings
    |--------------------------------------------------------------------------
    */

    // Expiry time in minutes (24 hours = 1440 minutes)
    'expiry_duration' => 1440,
    'expiry_unit' => 'minutes',

    /*
    |--------------------------------------------------------------------------
    | Enabled Payment Methods
    |--------------------------------------------------------------------------
    |
    | Metode pembayaran yang diizinkan:
    | - BCA Virtual Account
    | - BRI Virtual Account  
    | - DANA (via other_qris)
    | - QRIS (generic)
    |
    */

    'enabled_payments' => [
        'bca_va',       // BCA Virtual Account
        'bri_va',       // BRI Virtual Account
        'dana',         // DANA e-wallet
        'qris',         // QRIS (generic - can use any QRIS app)
        'other_qris',   // Other QRIS providers
    ],

    /*
    |--------------------------------------------------------------------------
    | Merchant Name (shown in Snap popup)
    |--------------------------------------------------------------------------
    */

    'merchant_name' => 'Vanillablue Photostudio',
];
