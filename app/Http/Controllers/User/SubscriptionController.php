<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class SubscriptionController extends Controller
{
    public function index(){

        $user = Auth::user('web')->parent;

        $subscription = null ;


        if (!$user) {
            $subscription = Auth::user('web')->subscription;
        }else {
            $subscription = User::findOrFail($user)->subscription;
        }

        if (!$subscription) {
            return null;
        }
        return view('user.subscriptions.index',compact('subscription'));


    }

    public function upgrade($id){

        $subscription = Subscription::findOrFail($id);

        $plans =  Plan::all();

        return view('user.subscriptions.upgrade',compact('subscription','plans'));
    }



    public function updateM($id){


        $plan = Plan::findOrFail($id);



        $subscription = Subscription::findOrFail(request()->id);

        $subscription->update([
            'plan_id' => $plan->id,
            'started_date' => Carbon::now(),
            'ended_date' => Carbon::now()->addMonth()
        ]);


        return redirect()->back()->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);
    }


    public function updateY($id){

        $plan = Plan::findOrFail($id);



        $subscription = Subscription::findOrFail(request()->id);

        $subscription->update([
            'plan_id' => $plan->id,
            'started_date' => Carbon::now(),
            'ended_date' => Carbon::now()->addYear()
        ]);


        return redirect()->back()->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);
    }



    public function cancel($id){

        $subscription = Subscription::findOrFail($id);

        $plan = Plan::where('name','LIKE', "%free%")->first();

        $subscription->update([
            'plan_id'=> $plan->id,
            'started_date'=>Carbon::now(),
            'ended_date'=>Carbon::now()->addMonth(),
        ]);

        return redirect()->back()->with([
            'message' => 'Cancled successfully',
            'alert-type' => 'success',
        ]);

    }
}
