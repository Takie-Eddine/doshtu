<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function index(){

        $subscriptions = Subscription::with(['user','plan'])
        ->when(\request()->status != null, function ($query) {
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
        ->paginate(\request()->limit_by ?? 10);

        return view('dashboard.subscriptions.index',compact('subscriptions'));

    }


    public function create(){

        $users = User::all();
        $plans = Plan::all();

        return view('dashboard.subscriptions.create',compact('users','plans'));

    }


    public function store(Request $request){

        $request->validate([

        ]);

    }



    public function edit($id){

        $subscription = Subscription::findOrFail($id);
        return view('dashboard.subscriptions.edit',compact('subscription'));
    }



    public function update(Request $request, $id){

        $request->validate([

        ]);

    }



    public function destroy($id){

    }

}
