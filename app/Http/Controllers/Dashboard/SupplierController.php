<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index(){
        $suppliers = Supplier::with('company')->when(request()->keyword != null,function ($query){
            $query->search(request()->keyword);
        })
        ->when(\request()->email != null, function ($query) {
            $query->search(request()->email);
        })
        ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
        ->paginate(\request()->limit_by ?? 10);

        return view('dashboard.suppliers.index',compact('suppliers'));
    }




    public function create(){

        return view('dashboard.suppliers.create');
    }




    public function store(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.Supplier::class],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $user = Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('admin.suppliers.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success',
        ]);
    }



    public function show(Supplier $supplier)
    {
        return view('dashboard.suppliers.show',compact('supplier'));
    }


    public function edit($id)
    {
        $supplier = Supplier::find($id);


        if (!$supplier) {
            return redirect()->route('dashboard.suppliers.index')->with([
                'message' => 'Not found',
                'alert-type' => 'danger',
            ]);
        }

        return view('dashboard.suppliers.edit',compact('supplier'));
    }


    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255',Rule::unique('suppliers','name')->ignore($id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('suppliers','email')->ignore($id)],
            'password' => ['nullable', Rules\Password::defaults()],
        ]);

        $supplier = Supplier::findOrFail($id);

        if ($request->password) {

            $supplier->update([
                'name' => $request->name,
                'email'=> $request->email,
                'password' => Hash::make($request->password),
            ]);
        }else {
            $supplier->update([
                'name' => $request->name,
                'email'=> $request->email,
            ]);
        };

        return redirect()->route('admin.suppliers.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);

    }


    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('admin.suppliers.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success',
        ]);
    }



    public function trash()
    {
        $suppliers = Supplier::onlyTrashed()->paginate();
        return view('dashboard.suppliers.trash',compact('suppliers'));
    }


    public function restore(Request $request ,$id)
    {
        $supplier = Supplier::onlyTrashed()->findOrFail($id);
        $supplier->restore();
        return redirect()->route('admin.suppliers.trash')->with([
            'message' => 'Supplier restored',
            'alert-type' => 'success',
        ]);
    }



    public function forceDelete($id)
    {
        $supplier = Supplier::onlyTrashed()->findOrFail($id);
        $supplier->forceDelete();

        return redirect()->route('admin.suppliers.trash')->with([
            'message' => 'Supplier deleted forever',
            'alert-type' => 'success',
        ]);
    }
}
