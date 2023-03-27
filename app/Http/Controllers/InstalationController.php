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

    /**
     * Three scenarios can hapen
     * New installation
     * Re-installation
     * Opening the app
     */

    public function startInstalation(Request $request){

        try{
            $validRequest = $this->validateRequestFromShopify($request->all());
            if($validRequest){
                $shop = $request->has('shop'); // check if shop parameter exists on the request
                if ($shop) {
                    $storeDetails = $this->getStoreByDomain($request->shop);
                    if ($storeDetails !== null && $storeDetails !== false) {
                        //store record exists and now determine whether the access token is valid or not
                        //if not then forward them to the re-instalation flow
                        //if yes then redirect them to the login page

                        $validAccessToken = $this->checkIfAccessTokenValid($storeDetails);
                        if($validAccessToken){
                            //Token is valid for shopify API calls so redirect to the login page
                            print_r('Here in the valid token part');exit;
                        }else{
                            //else is not valid so redirect the user to the  re-instalation phase
                            print_r('Here in the not  valid token part');exit;
                        }
                    }else {
                        //new instalation flow should be carried out
                        //https://{shop}.myshopify.com/admin/oauth/authorize?client_id={client_id}&scope={scopes}&redirect_uri={redirect_uri}&state={nonce}&grant_options[]={access_mode}
                        Log::info('New installation for shop'.$request->shop);
                        $endpoint = 'https://'.$request->shop.
                                    '/admin/oauth/authorize?client_id='.config('custom.shopify_api_key').
                                    '&scope='.config('custom.api_scopes').
                                    '&redirect_uri='.route('app_install_redirect');
                        return Redirect::to($endpoint);
                    }
                }else throw new Exception('shop parameter not present in the request');
            }else throw new Exception('Request is not valid');
        }catch(Exception $ex){
            Log::info($ex->getMessage().' '.$ex->getLine());
            dd($ex->getMessage().' '.$ex->getLine());
        }

    }

    public function handleRedirect(Request $request){
        try{
            $validRequest = $this->validateRequestFromShopify($request->all());
            if($validRequest){
                Log::info(json_encode($request->all()));
                if($request->has('shop') && $request->has('code')){
                    $shop = $request->shop;
                    $code = $request->code;
                    $accessToken = $this->requestAcessTokenFromShopifyForThisStore($shop, $code);
                    Log::info($shop);
                    Log::info($accessToken);
                    if($accessToken !==false && $accessToken !==null){
                        $shopDetails = $this->getShopDetailsFromShopify($shop, $accessToken);
                        $saveDetails = $this->saveStoreDetailsToDatabase($shopDetails, $accessToken);
                        Log::info($shopDetails);
                        if($saveDetails){
                            //At this point the installation process is complete.
                            Redirect::route('app_install_complete');
                        }else {
                            Log::info('problem during saving shop details into db');
                            Log::info($saveDetails);
                            dd('Problem during installation. please check logs.');
                        }
                    }else throw new Exception('Invalid Access Token '. $accessToken);
                }else throw new Exception('code / shop param not present in the URL');
            }else throw new Exception('Request is not valid!');
        }catch(Exception $ex){
            Log::info($ex->getMessage().''.$ex->getLine());
            dd($ex->getMessage().''.$ex->getLine());
        }
    }


    public function saveStoreDetailsToDatabase($shopDetails, $accessToken){
        try{
            $payload = [
                'access_token' => $accessToken,
                'myshopify_domain' => $shopDetails['myshopify_domain'],
                'id' => $shopDetails['id'],
                'name' => $shopDetails['name'],
                'phone' => $shopDetails['phone'],
                'address1' => $shopDetails['address1'],
                'address2' => $shopDetails['address2'],
                'zip' => $shopDetails['zip'],
            ];
            Store::updateOrCreate(['myshopify_domain'=> $shopDetails['myshopify_domain']],$payload);
            return Redirect::to('https://doshtudashboard.doshtu.com/en/login');
            //return true;
        }catch(Exception $ex){
            Log::info($ex->getMessage().''.$ex->getLine());
            return false;
        }
    }


    public function completeInstalation(Request $request){
        //At this point the installation is complete so redirect the browser to either the login page or anywhere u want.
        print_r('Instalation complete !!');exit;
    }


    private function getShopDetailsFromShopify($shop, $accessToken){
        try {
            $endpoint = getShopifyURLForStore('shop.json',['myshopify_domain' => $shop]);
            $headers = getShopifyHeadersForStore(['access_token' => $accessToken]);
            $response = $this->makeAnAPICallToShopify('GET', $endpoint, null, $headers);
            if($response['statusCode'] == 200){
                $body = $response['body'];
                if(!is_array($body)) $body = json_decode($body,true);
                return $body['shop'] ?? null;
            }else{
                Log::info('Response recived for shop details');
                Log::info($response);
                return null;
            }
        } catch (Exception $ex) {
            Log::info('Problem getting the shop details from shopify');
            Log::info($ex->getMessage().''.$ex->getLine());
            return null;
        }
    }


    private function requestAcessTokenFromShopifyForThisStore($shop, $code){
        try{
            //https://{shop}.myshopify.com/admin/oauth/access_token?client_id={client_id}&client_secret={client_secret}&code={authorization_code}
            $endpoint = 'https://'.$shop.'./admin/oauth/access_token';
            $headers = ['Content-Type:application/json'];
            $requestBody = json_encode([
                'client_id' => config('custom.shopify_api_key'),
                'client_secret' => config('custom.shopify_api_secret'),
                'code' => $code,
            ]);
            $response = $this->makeAPOSTCallToShopify($requestBody, $endpoint, $headers);

            if($response['statusCode'] == 200){
                $body = $response['body'];
                if(!is_array($body)) $body = json_decode($body, true);
                Log::info('Body here');
                Log::info($body);
                if(is_array($body) && isset($body['access_token']) && $body['access_token']!== null)
                    return $body['access_token'];
            }
            return false;
        }catch(Exception $ex){
            return false;
        }
    }


    private function validateRequestFromShopify($request){
        try{
            $arr= [];
            $hmac = $request['hmac'];
            unset($request['hmac']);
            foreach($request as $key=>$value){
                $key=str_replace("%","%25",$key);
                $key=str_replace("&","%26",$key);
                $key=str_replace("=","%3D",$key);
                $value=str_replace("%","%25",$value);
                $value=str_replace("&","%26",$value);
                $arr[] = $key."=".$value;
            }
            $str = implode('&',$arr);
            $ver_hmac =  hash_hmac('sha256',$str,config('custom.shopify_api_secret'),false);
            return $ver_hmac === $hmac ;
        }catch(Exception $ex){
            Log::info('problem with verify hmac from request');
            Log::info($ex->getMessage().''.$ex->getLine());
            return false ;
        }

    }

    /**
     * write some code here that will use Guzzle library to fetch the shop object from shopify API
     * if it succeeds with 200 status then that  means its valid and we can return true;
     */


    private function checkIfAccessTokenValid($storeDetails){
        try {
            if($storeDetails !== null && isset($storeDetails->access_token) && strlen($storeDetails->access_token) >0){
                $token = $storeDetails->access_token;

                $endpoint = getShopifyURLForStore('shop.json',$storeDetails);
                $headers = getShopifyHeadersForStore($storeDetails);
                $response = $this->makeAnAPICallToShopify('GET', $endpoint, null, $headers, null);
                Log::info('Response for checkingthe validity of token');
                Log::info($response);
                return $response['statusCode'] === 200;
            }

            return false;
        } catch (Exception $ex) {
            return false;
        }
    }
}
