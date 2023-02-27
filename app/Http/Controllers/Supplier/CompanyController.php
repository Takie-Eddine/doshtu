<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Symfony\Component\Intl\Countries;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as Image;


class CompanyController extends Controller
{
    public function index(){

        $company = auth()->user()->company;

        if ($company) {
            return view('supplier.company.edit',[
                'company' => $company,
                'countries' => Countries::getNames(),
            ]);
        }

        return view('supplier.company.index',[
            'company' => $company,
            'countries' => Countries::getNames(),
        ]);
    }


    public function store(Request $request){

        $request->validate([
            'company_name' => ['required' ,'string' , 'min:5' , 'max:255'],
            'email' => ['required', 'string', 'email', Rule::unique('companies','email')],
            'description' => ['required', 'string', 'min:30'],
            'mobile' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', Rule::unique('companies','mobile')] ,
            'mobile_office' => ['nullable', 'regex:/^([0-9\s\-\+\(\)]*)$/', Rule::unique('companies','office_mobile')] ,
            'image' => ['nullable', 'mimes:jpg,jpeg,png'],
            'country' => ['required' ,'string' , 'size:2'],
            'city' => ['nullable' ,'string'],
            'state' => ['nullable' ,'string'],
            'pincode' => ['nullable' , 'integer'],
            'address' => ['required', 'string', 'min:10', 'max:255'],
            'website' => ['nullable','url'],
        ]);


        try{
            DB::beginTransaction();


            if ($image = $request->file('image')) {

                $file_name = Str::slug($request->company_name).".".$image->getClientOriginalExtension();
                $path = public_path('/assets/company_logos/' .$file_name);
                Image::make($image->getRealPath())->resize(500,null,function($constraint){
                    $constraint->aspectRatio();
                })->save($path,100);

                $request->image = $file_name;
            }


            $company = Company::create([
                'company_name' => $request->company_name,
                'email' => $request->email,
                'description' => $request->description,
                'mobile' => $request->mobile,
                'office_mobile' => $request->mobile_office,
                'country' => $request->country,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'address' => $request->address,
                'website' => $request->website,
                'logo' => $request->image,
            ]);


            Auth::user('supplier')->company_id = $company->id;

            Auth::user('supplier')->save();


            DB::commit();


            return redirect()->back()->with([
                'message' => 'Created successfully',
                'alert-type' => 'success',
            ]);

        }catch(Exception $ex){

            return $ex ;
            DB::rollback();
        }

    }


    public function update(Request $request){

        $id = Auth::user('supplier')->company_id;

        $request->validate([
            'company_name' => ['required' ,'string' , 'min:5' , 'max:255'],
            'email' => ['required', 'string', 'email', Rule::unique('companies','email')->ignore($id)],
            'description' => ['required', 'string', 'min:30'],
            'mobile' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', Rule::unique('companies','mobile')->ignore($id)] ,
            'mobile_office' => ['nullable', 'regex:/^([0-9\s\-\+\(\)]*)$/', Rule::unique('companies','office_mobile')->ignore($id)] ,
            'image' => ['nullable', 'mimes:jpg,jpeg,png'],
            'country' => ['required' ,'string' , 'size:2'],
            'city' => ['nullable' ,'string'],
            'state' => ['nullable' ,'string'],
            'pincode' => ['nullable' , 'integer'],
            'address' => ['required', 'string', 'min:10', 'max:255'],
            'website' => ['nullable','url'],
        ]);


        Auth::user('supplier')->company->fill($request->all())->save();

        return redirect()->back()->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);

    }



    public function remove_image(Request $request){

        $company = Company::findOrFail($request->company_id);

        if (File::exists('assets/company_logos/'.$company->logo)) {
            unlink('assets/company_logos/'.$company->logo);
            $company->logo = null ;
            $company->save();
        }

        return true;


    }


}
