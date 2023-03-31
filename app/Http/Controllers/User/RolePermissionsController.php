<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use Illuminate\Http\Request;

class RolePermissionsController extends Controller
{
    public function rolepermission(){

        $roles = RoleUser::get();
        return view('user.role.index',compact('roles'));

    }


    public function create(){

        return view('user.role.create');
    }


    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'permissions' => 'required|array|min:1',
        ]);
        try {

            $role = $this->process(new RoleUser, $request);
            if ($role)
                return redirect()->route('user.role-permissions.index')->with([
                    'message' => 'Created successfully',
                    'alert-type' => 'success',
                ]);
            else
                return redirect()->route('user.role-permissions.index')->with([
                    'message' => 'there is a problem',
                    'alert-type' => 'danger',
                ]);
        } catch (\Exception $ex) {
            return $ex;
            // return message for unhandled exception
            return redirect()->route('user.role-permissions.index')->with([
                'message' => 'there is a problem',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function edit($id)
    {
        $role = RoleUser::findOrFail($id);
        return view('user.role.edit',compact('role'));
    }

    public function update($id,Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required|array|min:1',
        ]);
        try {
            $role = RoleUser::findOrFail($id);
            $role = $this->process($role, $request);
            if ($role)
                return redirect()->route('user.role-permissions.index')->with([
                    'message' => 'Updated successfully',
                    'alert-type' => 'success',
                ]);
            else
                return redirect()->route('user.role-permissions.index')->with([
                    'message' => 'there is a problem',
                    'alert-type' => 'danger
                ']);
        } catch (\Exception $ex) {
            // return message for unhandled exception
            return redirect()->route('user.role-permissions.index')->with([
                'message' => 'there is a problem',
                'alert-type' => 'danger'
            ]);
        }
    }

    protected function process(RoleUser $role, Request $r)
    {
        $role->name = $r->name;
        $role->permissions = json_encode($r->permissions);
        $role->save();
        return $role;
    }
    public function delete(Request $request,$id){

        //return $request;
        $role = RoleUser::findOrFail($id);

        $role->delete();

        return redirect()->back()->with([
            'success' => 'delete successfully',
            'alert-type' => 'success',
        ]);


    }
}
