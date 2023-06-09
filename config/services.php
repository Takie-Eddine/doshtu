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


    'paypal' => [
        'mode' => 'sandbox',
        'client_id' => 'AQMy2O4ztSGxMm-qTcERSh3xo_A8es_iq17qCIPIAx_8G1Bsrpw6rnUfafSv46ehenG22L3f7GuLtAdv',
        'secret' => 'EAIwljJ4aoHheTeC69ATIkUc2OBBm8lgs61mgDAApxLIOvHhfjvL1eYLaJAnPB5dwo13Lwz4wq1DwPPi',

    ]

];
