<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStore
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $user = Auth::user('web')->is_admin;



        if ($user) {
            $subscription = User:: FindOrFail($user)->subscription;
        }else{
            $subscription = Auth::user('web')->subscription;
        }

        if (!$subscription) {
            return redirect()->route('user.subscribe.create')->with([
                'message' => 'Please you have to complate your subscription',
                'alert-type' => 'danger',
            ]);
        }

        if ($subscription && $subscription->status == 'unpaid') {
            return redirect()->route('user.subscribe.payment')->with([
                'message' => 'Please you have to complate your subscription',
                'alert-type' => 'danger',
            ]);
        }



        return $next($request);
    }
}
