<?php

if (!function_exists('getShopifyURLForStore')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function getShopifyURLForStore($endpoint, $store )
    {
        return 'https://'.$store['shopify_domain'].'/admin/api'.config('custom.shopify_api_version').'/'.$endpoint;
    }

    function getShopifyHeadersForStore($soreDetails){
        return[
            'Content-Type' => 'application/json',
            'x-Shopify-Access-Token' => $soreDetails->access_token
        ];
    }
}
