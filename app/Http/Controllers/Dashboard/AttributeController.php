<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AttributeController extends Controller
{
    public function index(){

        $attributes = Attribute::paginate();

        return view('dashboard.attributes.index',compact('attributes'));
    }


    public function create(){

        return view('dashboard.attributes.create');
    }


    public function store(Request $request){

        $request->validate([
            'name_en' => ['required', 'string', Rule::unique('attributes','name')],
            'name_ar' => ['required', 'string', Rule::unique('attributes','name')],
        ]);

        Attribute::create([
            'name' => [
                        'en' => $request->name_en,
                        'ar' => $request->name_ar,
                    ],
        ]);


        return redirect()->route('admin.attributes.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success',
        ]);

    }

    public function edit($id){

        $attribute = Attribute::findOrFail($id);

        return view('dashboard.attributes.edit',compact('attribute'));
    }


    public function update(Request $request, $id){

        $request->validate([
            'name_en' => ['required', 'string', Rule::unique('attributes','name')->ignore($id)],
            'name_ar' => ['required', 'string', Rule::unique('attributes','name')->ignore($id)],
        ]);


        $attribute = Attribute::findOrFail($id);

        $attribute->update([
            'name' => [
                'en' => $request->name_en,
                'ar' => $request->name_ar,
            ],
        ]);


        return redirect()->route('admin.attributes.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);

    }



    public function destroy($id){

        $attribute = Attribute::findOrFail($id);
        $attribute->delete();
        return redirect()->route('admin.attributes.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
