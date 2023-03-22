<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Store;
use App\Traits\FunctionTrait;
use App\Traits\RequestTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class InstalationController extends Controller
{
    use FunctionTrait, RequestTrait;

    //public $scopes = 'write_orders,write_fulfillments,read_all_orders,write_customers,read_products,write_products,read_locations';

    public function startInstalation(Request $request){

        try {
            $validRequest = $this->validateRequestFromShopify($request->all());
            if ($validRequest) {
                $shop = $request->has('shop');
                if ($shop) {
                    $storeDetails = $this->getStoreByDomain($request->shop);
                    if ($storeDetails !== null && $storeDetails !== false) {

                        $validAccessToken = $this->checkIfAccessTokenIsValid($storeDetails);
                        if ($validAccessToken) {
                            print_r('here in the valid token part');exit;
                        }else{
                            print_r('here in the not valid token part');exit;
                        }

                    }else {
                        //print_r('new instalation begins here');exit;

                        //https://{shop}.myshopify.com/admin/oauth/authorize?client_id={client_id}&scope={scopes}&redirect_uri={redirect_uri}&state={nonce}&grant_options[]={access_mode}

                        Log::info('New instalation for shop'.$request->shop);

                        $endpoint = 'https://'.$request->shop.
                                    '/admin/oauth/authorize?client_id='.config('custom.shopify_api_key').
                                    '&scope='.config('custom.api_scopes').
                                    '&redirect_uri='.route('app_install_redirect');

                        return Redirect::to($endpoint);
                    }

                }else throw new Exception('shop parameter not present in the request');

            } else throw new Exception('Request is not valid!');

        } catch (Exception $ex) {
            Log::info($ex->getMessage().''.$ex->getLine());
            dd($ex->getMessage());
        }

    }


    public function handleRedirect(Request $request){
        try {
            $validRequest = $this->validateRequestFromShopify($request->all());
            if ($validRequest) {
                Log::info(json_encode($request->all()));
                if ($request->has('shop') && $request->has('code') ) {
                    $shop = $request->shop ;
                    $code = $request->code ;
                    $accessToken = $this->requestAccessTokenFromShopifyForThisStore($shop,$code);
                    if ($accessToken !==false && $accessToken !==null) {
                        $shopdetails = $this->getShopDetailsFromShopify($shop, $accessToken);
                        $saveDetails = $this->saveStoreDetailsToDatabase($shopdetails, $accessToken);
                        if ($saveDetails) {
                            Redirect::to(route('app_install_complete'));
                        }else {
                            Log::info('problem during saving shop details');
                            Log::info($saveDetails);
                            dd('problem during installation. please check logs.');
                        }
                    }else throw new Exception('Invalid Access Token '.$accessToken);

                }else throw new Exception('code/shop not present in the URL');

            }else throw new Exception('Request is not valid');

        } catch (Exception $ex) {
            Log::info($ex->getMessage().''.$ex->getLine());
            dd($ex->getMessage().''.$ex->getLine());
        }

    }


    public function completeInstalation(Request $request){

        print_r('Instalation complete !!'); exit;
    }


    public function saveStoreDetailsToDatabase($shopdetails, $accessToken){
        try{
            $payload = [
                'access_token' => $accessToken,
                'myshopify_domain' => $shopdetails['myshopify_domain'],
                'shopify_id' => $shopdetails['id'],
                'store_name' => $shopdetails['name'],
                'store_mobile' => $shopdetails['phone'],
                'address' => $shopdetails['address'],
                'country' => $shopdetails['country'],
                'city' => $shopdetails['city'],
                'zip' => $shopdetails['zip'],
            ];

            Store::updateOrcreate(['myshopify_domain' => $shopdetails['myshopify_domain']], $payload);
            return true;
        }catch(Exception $ex){
            Log::info($ex->getMessage().''.$ex->getLine());
            return false;
        }
    }



    private function getShopDetailsFromShopify($shop, $accessToken){
        try {
            $endpoint = getShopifyURLForStore('shop.json',['myshopify_domain'=>$shop]);
            $headers = getShopifyHeadersForStore(['access_token' => $accessToken]);
            $response = $this->makeAnAPICallToShopify('GET', $endpoint, null, $headers);
            if ($response['statusCode'] == 200) {
                $body = $response['body'];
                if (!is_array($body)) {
                    $body = json_decode($body,true);
                }
                return $body['shop'] ?? null;
            }else{
                Log::info('Response rercived for shop details');
                Log::info($response);
                return null ;
            }
        } catch (\Exception $ex) {
            Log::info('problem getting the shop details from shopify');
            Log::info($ex->getMessage().''.$ex->getLine());
            return null;
        }
    }



    private function requestAccessTokenFromShopifyForThisStore($shop,$code){
        try {
            $endpoint = 'https://'.$shop.'/admin/oauth/access_token';
            $headers = ['Content-Type:application/json'];
            $requestBody = json_encode([
                    'client_id' => config('custom.shopify_api_key'),
                    'client_secret' => config('custom.shopify_api_secret'),
                    'code' => $code,
            ]);
            $response = $this->makeAPOSTCallToShopify($requestBody, $endpoint, $headers);

            if ($response['statusCode'] == 200) {
                $body = $response['body'];
                if(! is_array($body)){
                    $body = json_decode($body,true);
                }
                Log::info('Body here');
                Log::info($body);
                if(isset($body['access_token']) && $body['access_token'] !== null){
                    return $body['access_token'];
                }
                return false;
            }
        } catch (Exception $ex) {

        }
    }


    private function validateRequestFromShopify($request){

        try {
            $arr= [];
            $hmac = $request['hmac'];
            unset($request['hmac']);

            foreach($request as $key => $value){

                $key=str_replace("%","%25",$key);
                $key=str_replace("&","%26",$key);
                $key=str_replace("=","%3D",$key);
                $value=str_replace("%","%25",$value);
                $value=str_replace("&","%26",$value);

                $arr[] = $key."=".$value;
            }

            $str = implode('&', $arr);
            $ver_hmac =  hash_hmac('sha256',$str,config('custom.shopify_api_secret'),false);

            return $ver_hmac === $hmac ;

        } catch (Exception $ex) {
            Log::info('Problem with verify hmac from request');
            Log::info($ex->getMessage().''.$ex->getLine());
            return false;
        }

    }


    private function checkIfAccessTokenIsValid($storeDetails){
        try {
            if ($storeDetails !==null && isset($storeDetails->access_token) && strlen($storeDetails->access_token) > 0) {
                $token = $storeDetails->access_token;

                $endpoint = getShopifyURLForStore('shop.json', $storeDetails);
                $headers = getShopifyHeadersForStore($storeDetails);
                $response = $this->makeAnAPICallToShopify('GET', $endpoint, null, $headers, null);
                Log::info('Response for checking the validity of token');
                Log::info($response);
                return $response['statusCode'] === 200;
            }


            return false;
        } catch (Exception $ex) {
            //throw $th;
            return false;
        }

    }
}
