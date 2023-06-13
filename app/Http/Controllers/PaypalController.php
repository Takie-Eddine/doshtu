<?php

namespace App\Http\Controllers;

use App\Models\Paypal;
use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalHttp\HttpException;

class PaypalController extends Controller
{
    public function checkout(Request $request, $id){

        //return $request ;

        $client = $this->getPaypalClient();

        $plan = Plan::findOrFail($id);
        if ($plan->annual_price == $request->price) {
            $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "Subscription to plan .{{$plan->name}}.",
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

            if ($response->statusCode == 201) {
                session()->put('paypal_order_id',$response->result->id);
                session()->put('plan',$plan);
                session()->put('price',$plan->annual_price);
                foreach ($response->result->links as $link) {
                    if ($link->rel == 'approve') {
                        return redirect()->away($link->href);
                    }
                }
            }

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            dd($response);
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
        }if($plan->monthly_price == $request->price){
            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');
            $request->body = [
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "reference_id" => "Subscription to plan .{{$plan->name}}.",
                    "amount" => [
                        "value" => $plan->monthly_price,
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

                if ($response->statusCode == 201) {
                    session()->put('paypal_order_id',$response->result->id);
                    session()->put('plan',$plan);
                    session()->put('price',$plan->monthly_price);
                    foreach ($response->result->links as $link) {
                        if ($link->rel == 'approve') {
                            return redirect()->away($link->href);
                        }
                    }
                }

                // If call returns body in response, you can get the deserialized version from the result attribute of the response
                dd($response);
            } catch (HttpException $ex) {
                echo $ex->statusCode;
                print_r($ex->getMessage());
            }
        }


    }


    public function paypalReturn(){

        $client = $this->getPaypalClient();
        $id = session()->get('paypal_order_id');
        $plan = session()->get('plan');
        $price = session()->get('price');
        $request = new OrdersCaptureRequest($id);
        $request->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            //dd($response);
            if ($response->result->status == 'COMPLETED') {
                if ($plan->annual_price == $price) {
                    Subscription::create([
                        'plan_id' => $plan->id,
                        'user_id' => Auth::user('web')->id,
                        'started_date' => Carbon::now(),
                        'ended_date' => Carbon::now()->addYear(),
                        'status' => 'paid',
                    ]);
                }
                if ($plan->monthly_price == $price) {
                    Subscription::create([
                        'plan_id' => $plan->id,
                        'user_id' => Auth::user('web')->id,
                        'started_date' => Carbon::now(),
                        'ended_date' => Carbon::now()->addMonth(),
                        'status' => 'paid',
                    ]);
                }

                Paypal::create([
                    'transaction_id' => $response->result->id,
                    'paypal_email' => $response->result->payer->email_address,
                    'created_time' => Carbon::now(),
                ]);

                return redirect()->route('user.dashboard')->with([
                    'message' => 'Your Subscription has completed ',
                    'alert-type' => 'success',
                ]);
            }
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }


    public function paypalCancel(){
        return redirect()->route('user.subscribe.create')->with([
            'message' => 'Please you have to complate your subscription',
            'alert-type' => 'danger',
        ]);
    }




    protected function getPaypalClient(){
        $config = config('services.paypal');
        $environment = new SandboxEnvironment($config['client_id'], $config['secret']);
        $client = new PayPalHttpClient($environment);
        return $client;
    }
}
