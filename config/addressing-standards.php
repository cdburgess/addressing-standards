<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Behavior
    |--------------------------------------------------------------------------
    |
    | Control high-level normalization preferences.
    |
    */

    'uppercase' => true,          // Pub 28 prefers uppercase

    'prefer_zip4' => true,        // Keep ZIP+4 when available

    /*
    |--------------------------------------------------------------------------
    | Secondary Unit Handling
    |--------------------------------------------------------------------------
    */

    'secondary' => [
        // When a designator that requires a number is present but the number
        // is missing, should we still emit the designator?
        'emit_incomplete_designator' => true,

        // Allow fallback to "# 123" when no recognized designator is found
        'allow_pound_sign_fallback' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Future / Optional Integrations
    |--------------------------------------------------------------------------
    */

    'usps_api' => [
        'enabled' => env('ADDRESSING_USPS_API_ENABLED', false),
        'client_id' => env('USPS_CLIENT_ID'),
        'client_secret' => env('USPS_CLIENT_SECRET'),
    ],

];