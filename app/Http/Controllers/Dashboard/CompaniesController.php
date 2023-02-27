<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\File;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class CompaniesController extends Controller
{

    public function index(){

        $request = request();
        $companies = Company::with('suppliers')
                                ->filter($request->query())
                                ->paginate();

        return view('dashboard.companies.index',compact('companies'));
    }


    public function create(){

        $suppliers = Supplier::whereNull('company_id')->whereNotNull('email_verified_at')->get();
        return view('dashboard.companies.create',[
            'suppliers' => $suppliers,
            'countries' => Countries::getNames(),
            'locales' => Languages::getNames(),
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
            'supplier' => ['nullable','exists:suppliers,id'],
        ]);

        try {

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
                'is_active' => 'active',
            ]);

            // $supplier = Supplier::findOrFail($request->supplier);
            // $supplier->update([
            //     'company_id' => $company->id,
            // ]);

            DB::commit();

            return redirect()->route('admin.companies.index')->with([
                'message' => 'Created successfully',
                'alert-type' => 'success',
            ]);

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.companies.index')->with($ex->getMessage());
        }





    }

    public function show(Company $company){
        return view('dashboard.companies.show',compact('company'));
    }



    public function edit($id){

        $suppliers = Supplier::whereNull('company_id')->whereNotNull('email_verified_at')->get();
        $company = Company::findOrFail($id);

        return view('dashboard.companies.edit',[
            'company' => $company,
            'suppliers' => $suppliers,
            'countries' => Countries::getNames(),
            'locales' => Languages::getNames(),
        ]);
    }



    public function update(Request $request, $id){


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
            'status' => ['in:active,unactive'],
            // 'supplier' => ['required','exists:suppliers,id'],
        ]);

        $company = Company::findOrFail($id);

        try {

            DB::beginTransaction();

            if ($photo = $request->file('image')) {
                if(File::exists('assets/company_logos/'.$company->logo) && $company->logo) {
                    unlink('assets/category_images/'.$company->logo);
                    $company->logo = null ;
                    $company->save();
                }
                $file_name = Str::slug($request->company__en).".".$photo->getClientOriginalExtension();
                $path = public_path('/assets/company_logos/' .$file_name);
                Image::make($photo->getRealPath())->resize(500,null,function($constraint){
                    $constraint->aspectRatio();
                })->save($path,100);

                $company->update([
                    'logo' => $file_name,
                ]);
            }

            $company->update([
                'company_name'=> $request->company_name  ,
                'email'=>$request-> email ,
                'description'=>$request->description  ,
                'mobile'=>$request-> mobile ,
                'mobile_office'=>$request-> mobile_office ,
                'country'=>$request-> country ,
                'city'=>$request-> city ,
                'state'=>$request-> state ,
                'pincode'=>$request-> pincode ,
                'address'=>$request-> address ,
                'website'=>$request->website  ,
                'is_active' => $request->status ,
            ]);

            // $supplier = Supplier::findOrFail($request->supplier);

            // $supplier->update([
            //     'company_id' => $company->id,
            // ]);

            DB::commit();

            return redirect()->route('admin.companies.index')->with([
                'message' => 'Updated successfully',
                'alert-type' => 'success',
            ]);

        } catch (\Exception $ex) {

            DB::rollback();
            return redirect()->route('admin.companies.index')->with($ex->getMessage());
        }
    }



    public function destroy($id){

        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('admin.companies.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success',
        ]);
    }


    public function trash()
    {
        $companies = Company::onlyTrashed()->paginate();
        return view('dashboard.companies.trash',compact('companies'));
    }


    public function restore(Request $request ,$id)
    {
        $company = Company::onlyTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('admin.companies.trash')->with([
            'message' => 'Company restored',
            'alert-type' => 'success',
        ]);
    }



    public function forceDelete($id)
    {
        $company = Company::onlyTrashed()->findOrFail($id);
        $suppliers = Supplier::where('company_id', '=',$company->id)->get();

        foreach ($suppliers as $supplier) {
            $supplier->update([
                'company_id'=> null,
            ]);
        }

        $company->forceDelete();
        if(File::exists('assets/company_images/'.$company->logo) && $company->logo) {
            unlink('assets/company_images/'.$company->logo);
        }

        return redirect()->route('admin.companies.trash')->with([
            'message' => 'Company deleted forever',
            'alert-type' => 'success',
        ]);
    }

}
