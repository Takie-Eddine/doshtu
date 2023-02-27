<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\RoleAdmin;
use Illuminate\Http\Request;

class RolePermissionsController extends Controller
{

    public function rolepermission(){

        $roles = RoleAdmin::get();
        return view('dashboard.role.index',compact('roles'));

    }


    public function create(){

        return view('dashboard.role.create');
    }


    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'permissions' => 'required|array|min:1',
        ]);
        try {

            $role = $this->process(new RoleAdmin, $request);
            if ($role)
                return redirect()->route('admin.role-permissions.index')->with([
                    'message' => 'Created successfully',
                    'alert-type' => 'success',
                ]);
            else
                return redirect()->route('admin.role-permissions.index')->with([
                    'message' => 'there is a problem',
                    'alert-type' => 'danger',
                ]);
        } catch (\Exception $ex) {
            return $ex;
            // return message for unhandled exception
            return redirect()->route('admin.role-permissions.index')->with([
                'message' => 'there is a problem',
                'alert-type' => 'danger',
            ]);
        }
    }

    public function edit($id)
    {
        $role = RoleAdmin::findOrFail($id);
        return view('dashboard.role.edit',compact('role'));
    }

    public function update($id,Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required|array|min:1',
        ]);
        try {
            $role = RoleAdmin::findOrFail($id);
            $role = $this->process($role, $request);
            if ($role)
                return redirect()->route('admin.role-permissions.index')->with([
                    'message' => 'Updated successfully',
                    'alert-type' => 'success',
                ]);
            else
                return redirect()->route('admin.role-permissions.index')->with([
                    'message' => 'there is a problem',
                    'alert-type' => 'danger
                ']);
        } catch (\Exception $ex) {
            // return message for unhandled exception
            return redirect()->route('admin.role-permissions.index')->with([
                'message' => 'there is a problem',
                'alert-type' => 'danger'
            ]);
        }
    }

    protected function process(RoleAdmin $role, Request $r)
    {
        $role->name = $r->name;
        $role->permissions = json_encode($r->permissions);
        $role->save();
        return $role;
    }

}
