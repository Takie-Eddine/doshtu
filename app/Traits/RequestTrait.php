<?php

namespace App\Traits ;

use Exception;
use GuzzleHttp\Client;

trait RequestTrait{
    public function makeAnAPICallToShopify($method, $endpoint, $url_params = null, $headers, $requestBody = null) {
        //Headers
        /**
         * Content-Type: application/json
         * X-Shopify-Access-Token: value
         */
        //Log::info('Endpoint '.$endpoint);
        try {
            $client = new Client();
            $response = null;
            if($method == 'GET' || $method == 'DELETE') {
                $response = $client->request($method, $endpoint, [ 'headers' => $headers ]);
            } else {
                $response = $client->request($method, $endpoint, [ 'headers' => $headers, 'json' => $requestBody ]);
            }
            return [
                'statusCode' => $response->getStatusCode(),
                'body' => json_decode($response->getBody(), true)
            ];
        } catch(Exception $e) {
            return [
                'statusCode' => $e->getCode(),
                'message' => $e->getMessage(),
                'body' => null
            ];
        }
    }

    public function makeAPOSTCallToShopify($data, $shopifyURL, $headers = NULL) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $shopifyURL);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers === NULL ? [] : $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $aHeaderInfo = curl_getinfo($ch);
        $curlHeaderSize = $aHeaderInfo['header_size'];
        $sBody = trim(mb_substr($result, $curlHeaderSize));

        return ['statusCode' => $httpCode, 'body' => $sBody];
    }

}
