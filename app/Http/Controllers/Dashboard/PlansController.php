<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str ;
use Intervention\Image\Facades\Image as Image;

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
            'image' => ['nullable'],
            'image.*' => 'mimes:jpg,jpeg,png,svg',
            'annualy_price' => ['nullable', 'numeric:decimal'],
            'monthly_price' => ['nullable', 'numeric:decimal'],
        ]);

        if ($photo = $request->file('image')) {
            $file_name = Str::slug($request->name_en).".".$photo->getClientOriginalExtension();
            $path = public_path('/assets/plan_images/' .$file_name);
            Image::make($photo->getRealPath())->resize(500,null,function($constraint){
                $constraint->aspectRatio();
            })->save($path,100);

            $request-> image =  $file_name;
            //return $input['photo'];
        }

        Plan::create([
            'name' => [
                        'ar'=>$request->name_ar,
                        'en'=>$request->name_en,
                    ],
            'description' => [
                        'ar'=>$request->description_ar,
                        'en'=>$request->description_en,
                    ],
            'image' => $request-> image,
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
        //return $request ;
        $request->validate([
            'name_ar' => ['required', 'string', Rule::unique('plans','name')->ignore($id)],
            'name_en' => ['required', 'string', Rule::unique('plans','name')->ignore($id)],
            'description_ar' => ['required'],
            'description_en' => ['required'],
            'image' => ['nullable'],
            'image.*' => 'mimes:jpg,jpeg,png,svg',
            'annualy_price' => ['nullable', 'numeric:decimal'],
            'monthly_price' => ['nullable', 'numeric:decimal'],
        ]);

        $plan = Plan::findOrFail($id);

        if ($photo = $request->file('image')) {
            if(File::exists('assets/plan_images/'.$plan->image) && $plan->image) {
                unlink('assets/plan_images/'.$plan->image);
                $plan->image = null ;
                $plan->save();
            }
            $file_name = Str::slug($request->name_en).".".$photo->getClientOriginalExtension();
            $path = public_path('/assets/plan_images/' .$file_name);
            Image::make($photo->getRealPath())->resize(100,null,function($constraint){
                $constraint->aspectRatio();
            })->save($path,100);

            $plan->update([
                'image' => $file_name,
            ]) ;
        }

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
