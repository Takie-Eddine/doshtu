<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use App\Models\Store;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UsersController extends Controller
{
    public function index(){

        $ids = Auth::user('web')->stores()->pluck('id') ;

        // $users = Auth::user('web')->children ;

        // return $users;


        $users = [] ;
        foreach ($ids as  $value) {
            $users = User::with('role')->whereHas('stores',function($q) use($value) {
                $q->where('store_id',$value);
            })->get();
        }


        //return $users ;


        return view('user.user.index',compact('users'));
    }


    public function create(){

        $stores = Auth::user('web')->stores;

        $roles = RoleUser::get();
        return view('user.user.create',compact('roles','stores'));
    }


    public function store(Request $request) {

        //return $request;
        $request->validate([

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'required|numeric|exists:role_users,id',
            'store' => ['required','array','min:1', Rule::exists('stores','id')],
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);   // the best place on model
        $user->role_id = $request->role_id;
        $user->is_admin = Auth::user('web')->id;





       // save the new user data
        if($user->save()){
            $user->stores()->sync($request->store);
            event(new Registered($user));
            return redirect()->route('user.user.index')->with([
                'message' => 'Created successfully',
                'alert-type' => 'success',
            ]);
        }
        else
            return redirect()->route('user.user.index')->with([
                'message' => 'there is a problem',
                'alert-type' => 'danger',
            ]);

    }



    public function edit($id){

        $user = User::find($id);
        $roles = RoleUser::get();

        if (!$user) {
            return redirect()->back()-> with([
                'message' => 'this user does not exist',
                'alert-type' => 'danger',
            ]);
        }

        return view('user.user.edit',compact('user','roles'));
    }



    public function update(Request $request,$id){
        //return $request;


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role_id' => 'required|numeric|exists:roles,id',
            'email' => ['required','email',Rule::unique('users','email')->ignore($id)],
            'password'  => 'required_without:id|confirmed',
        ]);

        $user = User::find($id);

        if (!$user) {
            return redirect()->back()-> with([
                'message' => 'this user does not exist',
                'alert-type' => 'danger',
            ]);
        }

        $user->update($request->except('_token', 'id','password_confirmation'));

        return redirect()->route('user.user.index')->with([
            'message' => 'updated successfully',
            'alert-type' => 'success',
        ]);
    }

    public function view($id){

        // $user = User::with('company','role')->find($id);
        // //$roles = Role::get();

        // if (!$user) {
        //     return redirect()->back()-> with([
        //         'message' => 'this user does not exist',
        //         'alert-type' => 'danger',
        //     ]);
        // }

        // return view('user.user.view',compact('user'));

    }


    public function delete($id){

        $user = User::find($id);
        if(!$user){

            return redirect()->route('user.user.index')->with([
                'message' => 'this user does not exist',
                'alert-type' => 'danger',
            ]);
        }
        $user -> delete();
        return redirect()->back()->with([
            'success' => 'delete successfully',
            'alert-type' => 'success',
        ]);

    }



}
