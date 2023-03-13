<?php

return [

    'shopify_api_key' => env('SHOPIFY_API_KEY','0ed0280adee03c0aeec228bced2986c9'),
    'shopify_api_secret' => env('SHOPIFY_API_SECRET','33e83461ba031dba90e56082bcb44bf9'),
    'shopify_api_version' => '2023-01',
    'api_scopes' => 'write_orders,read_orders,write_fulfillments,write_customers,read_products,write_products,read_locations',

];
