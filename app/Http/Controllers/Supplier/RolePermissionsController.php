<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionsController extends Controller
{
    public function rolepermission(){

        $roles = Role::get();
        return view('supplier.role.index',compact('roles'));

    }


    public function create(){

        return view('supplier.role.create');
    }


    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'permissions' => 'required|array|min:1',
        ]);
        try {

            $role = $this->process(new Role, $request);
            if ($role)
                return redirect()->route('supplier.role-permissions.index')->with([
                    'message' => 'Created successfully',
                    'alert-type' => 'success',
                ]);
            else
                return redirect()->route('supplier.role-permissions.index')->with([
                    'message' => 'there is a problem',
                    'alert-type' => 'danger',
                ]);
        } catch (\Exception $ex) {
            return $ex;
            // return message for unhandled exception
            return redirect()->route('supplier.role-permissions.index')->with([
                'message' => 'there is a problem',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('supplier.role.edit',compact('role'));
    }

    public function update($id,Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required|array|min:1',
        ]);
        try {
            $role = Role::findOrFail($id);
            $role = $this->process($role, $request);
            if ($role)
                return redirect()->route('supplier.role-permissions.index')->with([
                    'message' => 'Updated successfully',
                    'alert-type' => 'success',
                ]);
            else
                return redirect()->route('ssupplier.role-permissions.index')->with([
                    'message' => 'there is a problem',
                    'alert-type' => 'danger
                ']);
        } catch (\Exception $ex) {
            // return message for unhandled exception
            return redirect()->route('supplier.role-permissions.index')->with([
                'message' => 'there is a problem',
                'alert-type' => 'danger'
            ]);
        }
    }

    protected function process(Role $role, Request $r)
    {
        $role->name = $r->name;
        $role->permissions = json_encode($r->permissions);
        $role->save();
        return $role;
    }


    public function delete(Request $request,$id){

        //return $request;
        $role = Role::findOrFail($id);

        $role->delete();

        return redirect()->back()->with([
            'success' => 'delete successfully',
            'alert-type' => 'success',
        ]);


    }

}
