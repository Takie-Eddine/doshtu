<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlansController extends Controller
{
    public function index(){

        $plans = Plan::all();

        return view('dashboard.plans.index',compact('plans'));
    }


    public function create(){
        return view('dashboard.plans.create');
    }


    public function store(Request $request){

        $request->validate([
            'name_ar' => ['required', 'string', Rule::unique('plans','name')],
            'name_en' => ['required', 'string', Rule::unique('plans','name')],
            'description_ar' => ['required'],
            'description_en' => ['required'],
            'annualy_price' => ['nullable', 'numeric:decimal'],
            'monthly_price' => ['nullable', 'numeric:decimal'],
        ]);

        Plan::create([
            'name' => [
                        'ar'=>$request->name_ar,
                        'en'=>$request->name_en,
                    ],
            'description' => [
                        'ar'=>$request->description_ar,
                        'en'=>$request->description_en,
                    ],
            'annual_price' => $request->annualy_price,
            'monthly_price' => $request->monthly_price,
        ]);


        return redirect()->route('admin.plans.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success',
        ]);
    }


    public function edit($id){

        $plan = Plan::findOrFail($id);
        return view('dashboard.plans.edit',compact('plan'));
    }


    public function update(Request $request, $id){
        $request->validate([
            'name_ar' => ['required', 'string', Rule::unique('plans','name')->ignore($id)],
            'name_en' => ['required', 'string', Rule::unique('plans','name')->ignore($id)],
            'description_ar' => ['required'],
            'description_en' => ['required'],
            'annualy_price' => ['nullable', 'numeric:decimal'],
            'monthly_price' => ['nullable', 'numeric:decimal'],
        ]);
        $plan = Plan::findOrFail($id);

        $plan->update([
            'name' => [
                'ar'=>$request->name_ar,
                'en'=>$request->name_en,
                    ],
            'description' => [
                        'ar'=>$request->description_ar,
                        'en'=>$request->description_en,
                    ],
            'annual_price' => $request->annualy_price,
            'monthly_price' => $request->monthly_price,
        ]);
        return redirect()->route('admin.plans.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);
    }


    public function destroy($id){
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return redirect()->route('admin.plans.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success',
        ]);
    }
}
