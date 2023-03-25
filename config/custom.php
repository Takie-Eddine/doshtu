<?php

return [

    'shopify_api_key' => env('SHOPIFY_API_KEY','9ce9a5bea07a8f9a1f504df72d37b546'),
    'shopify_api_secret' => env('SHOPIFY_API_SECRET','223acb85ecaec215a8fc91f3ef97db96'),
    'shopify_api_version' => '2023-01',
    'api_scopes' => 'write_orders,write_fulfillments,read_orders,write_customers,read_products,write_products,read_locations',

];
