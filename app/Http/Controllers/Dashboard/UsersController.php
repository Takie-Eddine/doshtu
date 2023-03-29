<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\RoleAdmin;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UsersController extends Controller
{
    public function index(){

        $admins = Admin::latest()->where('id', '<>', auth()->id())->get();



        return view('dashboard.user.index',compact('admins'));
    }


    public function create(){

        $roles = RoleAdmin::get();
        return view('dashboard.user.create',compact('roles'));
    }


    public function store(Request $request) {

        //return $request;
        $request->validate([

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Admin::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'required|numeric|exists:roles,id',
        ]);

        $user = new Admin();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);   // the best place on model
        $user->role_id = $request->role_id;
        // $user->company_id = auth('admin')->user()->company_id;

       // save the new user data
        if($user->save()){
            event(new Registered($user));
            return redirect()->route('admin.user.index')->with([
                'message' => 'Created successfully',
                'alert-type' => 'success',
            ]);
        }
        else
            return redirect()->route('admin.user.index')->with([
                'message' => 'there is a problem',
                'alert-type' => 'danger',
            ]);

    }



    public function edit($id){

        $admin = Admin::find($id);
        $roles = RoleAdmin::get();

        if (!$admin) {
            return redirect()->back()-> with([
                'message' => 'this user does not exist',
                'alert-type' => 'danger',
            ]);
        }

        return view('dashboard.user.edit',compact('admin','roles'));
    }



    public function update(Request $request,$id){
        //return $request;


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role_id' => 'required|numeric|exists:roles,id',
            'email' => ['required','email',Rule::unique('admins','email')->ignore($id)],
            'password'  => 'required_without:id|confirmed',
        ]);

        $admin = Admin::find($id);

        if (!$admin) {
            return redirect()->back()-> with([
                'message' => 'this user does not exist',
                'alert-type' => 'danger',
            ]);
        }

        $admin->update([
            'name'=> $request->name,
            'role_id' => $request->role_id,
            'email' => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        //$admin->update($request->except('_token', 'id','password','password_confirmation'));

        return redirect()->route('admin.user.index')->with([
            'message' => 'updated successfully',
            'alert-type' => 'success',
        ]);
    }

    public function view($id){

        $admin = Admin::with('role')->find($id);
        //$roles = Role::get();

        if (!$admin) {
            return redirect()->back()-> with([
                'message' => 'this user does not exist',
                'alert-type' => 'danger',
            ]);
        }

        return view('dashboard.user.view',compact('admin'));

    }


    public function delete($id){

        $admin = Admin::find($id);
        if(!$admin){

            return redirect()->route('admin.user.index')->with([
                'message' => 'this user does not exist',
                'alert-type' => 'danger',
            ]);
        }
        $admin -> delete();
        return redirect()->back()->with([
            'success' => 'delete successfully',
            'alert-type' => 'success',
        ]);

    }
}
