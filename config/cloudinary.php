<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary API Configuration
    |--------------------------------------------------------------------------
    */

    'cloud' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME', ''),
        'api_key'    => env('CLOUDINARY_API_KEY', ''),
        'api_secret' => env('CLOUDINARY_API_SECRET', ''),
    ],

    /*
    |--------------------------------------------------------------------------
    | Optional: Upload Preset and other settings
    |--------------------------------------------------------------------------
    */
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET', null),
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL', null),
    'upload_route' => env('CLOUDINARY_UPLOAD_ROUTE', null),
    'upload_action' => env('CLOUDINARY_UPLOAD_ACTION', null),
];
