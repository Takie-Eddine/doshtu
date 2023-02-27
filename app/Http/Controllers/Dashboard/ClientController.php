<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index(){
        $request = request();
        $users = User::filter($request->query())->paginate();

        return view('dashboard.clients.index',compact('users'));
    }




    public function create(){

        return view('dashboard.clients.create');
    }




    public function store(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('admin.clients.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success',
        ]);
    }



    public function show(User $user)
    {
        return view('dashboard.clients.show',compact('user'));
    }


    public function edit($id)
    {
        $user = User::find($id);


        if (!$user) {
            return redirect()->route('dashboard.clients.index')->with([
                'message' => 'Not found',
                'alert-type' => 'danger',
            ]);
        }

        return view('dashboard.clients.edit',compact('user'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255',Rule::unique('users','name')->ignore($id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users','email')->ignore($id)],
            'password' => ['nullable', Rules\Password::defaults()],
        ]);

        $user = User::findOrFail($id);

        if ($request->password) {

            $user->update([
                'name' => $request->name,
                'email'=> $request->email,
                'password' => Hash::make($request->password),
            ]);
        }else {
            $user->update([
                'name' => $request->name,
                'email'=> $request->email,
            ]);
        };

        return redirect()->route('admin.clients.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);

    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.clients.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success',
        ]);
    }



    public function trash()
    {
        $users = User::onlyTrashed()->paginate();
        return view('dashboard.clients.trash',compact('users'));
    }


    public function restore(Request $request ,$id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('admin.clients.trash')->with([
            'message' => 'User restored',
            'alert-type' => 'success',
        ]);
    }



    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('admin.clients.trash')->with([
            'message' => 'User deleted forever',
            'alert-type' => 'success',
        ]);
    }

}
