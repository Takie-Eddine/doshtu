<?php

namespace App\Traits ;

use Exception;
use GuzzleHttp\Client;

trait RequestTrait{
    public function makeAnAPICallToShopify($method = 'GET', $endpoint, $url_params = null, $headers, $requestBody = null){
        //headers
        /*
        Content-Type:application/json
        X-Shopify-Access-Token: value
        */
        try{
            $client = new Client();
            $response = null;
            switch ($method) {
                case 'GET':
                    $response = $client->request($method, $endpoint, ['headers' => $headers]);
                    break;

                case 'POST':
                    $response = $client->request($method, $endpoint, ['headers' => $headers, 'json' => $requestBody]);
                    break;

            }


            return [
                'statusCode' => $response->getStatusCode(),
                'body' => $response->getBody(),
            ];
        }catch(Exception $ex){
            return [
                'statusCode' => $ex->getCode(),
                'message' => $ex->getMessage(),
                'body' => null,
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
