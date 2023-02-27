<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function index(){

        $suppliers = Supplier::latest()->where('company_id', auth('supplier')->user()->company_id)->where('id', '<>', auth()->id())->get();



        return view('supplier.user.index',compact('suppliers'));
    }


    public function create(){

        $roles = Role::get();
        return view('supplier.user.create',compact('roles'));
    }


    public function store(Request $request) {

        //return $request;
        $request->validate([

            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Supplier::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => 'required|numeric|exists:roles,id',
        ]);

        $user = new Supplier();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);   // the best place on model
        $user->role_id = $request->role_id;
        $user->company_id = auth('supplier')->user()->company_id;

       // save the new user data
        if($user->save()){
            event(new Registered($user));
            return redirect()->route('supplier.user.index')->with([
                'message' => 'Created successfully',
                'alert-type' => 'success',
            ]);
        }
        else
            return redirect()->route('supplier.user.index')->with([
                'message' => 'there is a problem',
                'alert-type' => 'danger',
            ]);

    }



    public function edit($id){

        $supplier = Supplier::find($id);
        $roles = Role::get();

        if (!$supplier) {
            return redirect()->back()-> with([
                'message' => 'this user does not exist',
                'alert-type' => 'danger',
            ]);
        }

        return view('supplier.user.edit',compact('supplier','roles'));
    }



    public function update(Request $request,$id){
        //return $request;


        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role_id' => 'required|numeric|exists:roles,id',
            'email' => ['required','email',Rule::unique('companies','email')->ignore($id)],
            'password'  => 'required_without:id|confirmed',
        ]);

        $supplier = Supplier::find($id);

        if (!$supplier) {
            return redirect()->back()-> with([
                'message' => 'this user does not exist',
                'alert-type' => 'danger',
            ]);
        }

        $supplier->update($request->except('_token', 'id','password_confirmation'));

        return redirect()->route('supplier.user.index')->with([
            'message' => 'updated successfully',
            'alert-type' => 'success',
        ]);
    }

    public function view($id){

        $supplier = Supplier::with('company','role')->find($id);
        //$roles = Role::get();

        if (!$supplier) {
            return redirect()->back()-> with([
                'message' => 'this user does not exist',
                'alert-type' => 'danger',
            ]);
        }

        return view('supplier.user.view',compact('supplier'));

    }


    public function delete($id){

        $supplier = Supplier::find($id);
        if(!$supplier){

            return redirect()->route('supplier.user.index')->with([
                'message' => 'this user does not exist',
                'alert-type' => 'danger',
            ]);
        }
        $supplier -> delete();
        return redirect()->back()->with([
            'success' => 'delete successfully',
            'alert-type' => 'success',
        ]);

    }
}
