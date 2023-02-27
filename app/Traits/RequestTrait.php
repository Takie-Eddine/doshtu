<?php

namespace App\Traits ;

use Exception;
use GuzzleHttp\Client;

trait RequestTrait{
    public function makeAnAPICallToShopify($method = 'GET', $url, $url_params = null, $headers, $requestBody = null){

        try {
            $client = new Client();
            $response = null;
            switch ($method) {
                case 'GET':
                    $response = $client->request($method, $url, ['headers'=>$headers]);
                    break;
            }
            //$response = $client->request($method, $url, ['headers'=>$headers]);

            return [
                'statusCode' => $response->getStatusCode(),
                'body' => $response->getBody(),
            ];

        } catch (Exception $ex) {
            return [
                'statusCode' => $ex->getCode(),
                'message' => $ex->getMessage(),
                'body' => null,
            ];
        }
    }

}
