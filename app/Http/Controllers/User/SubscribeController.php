<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;

class SubscribeController extends Controller
{
    public function create(){

        $plans = Plan::all();

        return view('user.subscriptions.create',compact('plans'));
    }



    public function storeM($id){

        $plan = Plan::findOrFail($id);

        $user_id = Auth::user('web')->parent;

        if ($user_id) {
            $user = User::findOrFail($user_id);

            Subscription::create([
                'user_id' => $user->id,
                'plan_id' =>$plan->id,
                'started_date'=> Carbon::now(),
                'ended_date' => Carbon::now()->addMonth(),
            ]);
            return redirect()->route('user.subscribe.payment');
        }

        Subscription::create([
            'user_id' => Auth::user('web')->id,
            'plan_id' =>$plan->id,
            'started_date'=> Carbon::now(),
            'ended_date' => Carbon::now()->addMonth(),
        ]);

        return redirect()->route('user.subscribe.payment');

    }

    public function storeY($id){
        $plan = Plan::findOrFail($id);

        $user_id = Auth::user('web')->parent;

        if ($user_id) {
            $user = User::findOrFail($user_id);

            Subscription::create([
                'user_id' => $user->id,
                'plan_id' =>$plan->id,
                'started_date'=> Carbon::now(),
                'ended_date' => Carbon::now()->addYear(),
            ]);
            return redirect()->route('user.subscribe.payment');
        }

        Subscription::create([
            'user_id' => Auth::user('web')->id,
            'plan_id' =>$plan->id,
            'started_date'=> Carbon::now(),
            'ended_date' => Carbon::now()->addYear(),
        ]);

        return redirect()->route('user.subscribe.payment');

    }



    public function payment(){

        return view('user.subscriptions.payment');

    }


    public function store(Request $request){

        $request->validate([
            'addCard' => ['required', new CardNumber],
            'card_name' => ['required','string','max:199'],
            'card_exp' => ['required'],
            'csv' => ['required'],
            'save' => ['nullable','in:on'],
        ]);


        // payment getway//


        if ($request->save) {

            Card::create([
                'user_id'=> Auth::user('web')->id,
                'number' => $request->addCard,
                'name' => $request->card_name,
                'experation_date' => $request->card_exp,
                'cvv' => $request->csv,
            ]);

            $subs = Subscription::where('user_id',Auth::user('web')->id);

            $subs->update([
                'status' => 'paid',
            ]);
        }

        return redirect()->route('user.dashboard')->with([
            'message' => 'Your Subscription has completed ',
            'alert-type' => 'success',
        ]);


    }


    public function free($id){
        $plan = Plan::findOrFail($id);

        $user_id = Auth::user('web')->parent;

        if ($user_id) {
            $user = User::findOrFail($user_id);

            Subscription::create([
                'user_id' => $user->id,
                'plan_id' =>$plan->id,
                'started_date'=> Carbon::now(),
                'ended_date' => Carbon::now()->addYear(),
                'status' => 'paid',
            ]);
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        Subscription::create([
            'user_id' => Auth::user('web')->id,
            'plan_id' =>$plan->id,
            'started_date'=> Carbon::now(),
            'ended_date' => Carbon::now()->addYear(),
            'status' => 'paid',
        ]);

        return redirect()->intended(RouteServiceProvider::HOME);
    }




    public function pay(){

        return view('user.subscriptions.paypal');
    }

}
