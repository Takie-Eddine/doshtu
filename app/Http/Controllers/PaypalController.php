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
    public function checkout(Request $request , $id){

        $client = $this->getPaypalClient();

        $plan = Plan::findOrFail($id);

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "Subscription Status",
                "amount" => [
                    "value" => "{{$plan->annual_price}}",
                    "currency_code" => "USD"
                ]
            ]],
            "application_context" => [
                "cancel_url" => "{{route('user.profile')}}",
                "return_url" => "{{route(''user.dashboard')}}"
            ]
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            print_r($response);
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }

    }




    protected function getPaypalClient(){
        $config = config('services.paypal');
        $environment = new SandboxEnvironment($config['client_id'], $config['secret']);
        $client = new PayPalHttpClient($environment);
        return $client;
    }
}
