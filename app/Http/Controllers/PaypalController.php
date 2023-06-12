<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use PaypalPayoutsSDK\Core\PayPalHttpClient;
use PaypalPayoutsSDK\Core\SandboxEnvironment;
use PaypalPayoutsSDK\Payouts\PayoutsPostRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;

class PaypalController extends Controller
{
    public function checkout($id){

        $client = $this->getPaypalClient();

        $plan = Plan::findOrFail($id);

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "Subscription Status",
                "amount" => [
                    "value" => $plan->annual_price,
                    "currency_code" => "USD"
                ]
            ]],
            "application_context" => [
                "cancel_url" => url(route('user.paypal.cancel')),
                "return_url" => url(route('user.paypal.return')),
            ]
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            dd($response);
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }

    }


    public function paypalReturn(){

    }


    public function paypalCancel(){

    }




    protected function getPaypalClient(){
        $config = config('services.paypal');
        $environment = new SandboxEnvironment($config['client_id'], $config['secret']);
        $client = new PayPalHttpClient($environment);
        return $client;
    }
}
