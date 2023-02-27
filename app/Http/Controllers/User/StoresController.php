<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class StoresController extends Controller
{
    public function index(){

        $stores = Auth::user('web')->stores()->get();

        return view('user.stores.index',compact('stores'));
    }


    public function create(){

        return view('user.stores.create',[
            'countries' => Countries::getNames(),
        ]);
    }


    public function store(Request $request){

        $request->validate([
            'store_name' => 'required|max:100|unique:stores,store_name',
            'store_email' => 'required|email|unique:stores,store_email',
            'store_mobile' => 'required|unique:stores,store_mobile',
            'store_logo' => ['nullable', 'mimes:jpg,jpeg,png'],
            'country'=> ['required' ,'string' , 'size:2'],
            'city'=>['required' ,'string'],
            'state'=>['nullable' ,'string'],
            'pincode'=>['required' , 'numeric', 'integer' ],
            'address'=>['required', 'string', 'min:10', 'max:255'],
        ]);

        if ($photo = $request->file('store_logo')) {
            $file_name = Str::slug($request->store_name).".".$photo->getClientOriginalExtension();
            $path = public_path('/assets/store_images/' .$file_name);
            Image::make($photo->getRealPath())->resize(500,null,function($constraint){
                $constraint->aspectRatio();
            })->save($path,100);

            $request->store_logo =  $file_name;

        }

        $store = Store::create([

            'store_name' => $request-> store_name,
            'store_email' => $request-> store_email,
            'store_mobile' => $request-> store_mobile,
            'store_logo' => $request-> store_logo,
            'country'=> $request-> country,
            'city'=> $request-> city,
            'state'=> $request-> state,
            'pincode'=> $request-> pincode,
            'address'=> $request-> address,
            'status' => 'active',
        ]);

        $store->users()->sync(Auth::user('web'));

        $stores = Auth::user('web')->stores;

        if ($stores->count()<2 && Auth::user('web')->is_admin == null) {

            $store->update([
                'default' => 1 ,
            ]);
            Session::put('store',$store);
        }


        return redirect()->route('user.stores.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success',
        ]);

    }


    public function edit($id){
        $store = Store::findOrFail($id);

        return view('user.stores.edit',[
            'countries' => Countries::getNames(),
            'store' => $store,
        ]);
    }


    public function update(Request $request, $id){

        //return $request;
        $request->validate([
            'store_name' => ['required','max:100',Rule::unique('stores','store_name')->ignore($id)],
            'store_email' => ['required','email',Rule::unique('stores','store_email')->ignore($id)],
            'store_mobile' => ['required',Rule::unique('stores','store_mobile')->ignore($id)],
            'store_logo' => ['nullable', 'mimes:jpg,jpeg,png'],
            'country'=> ['required' ,'string' , 'size:2'],
            'city'=>['required' ,'string'],
            'state'=>['nullable' ,'string'],
            'pincode'=>['required' , 'numeric', 'integer' ],
            'address'=>['required', 'string', 'min:10', 'max:255'],
        ]);

        $store = Store::findOrFail($id);


        if ($photo = $request->file('store_logo')) {
            if(File::exists('assets/store_images/'.$store->store_logo) && $store->store_logo) {
                unlink('assets/store_images/'.$store->store_logo);
                $store->store_logo = null ;
                $store->store_logo->save();
            }

            $file_name = Str::slug($request->store_logo).".".$photo->getClientOriginalExtension();
            $path = public_path('/assets/store_images/' .$file_name);
            Image::make($photo->getRealPath())->resize(500,null,function($constraint){
                $constraint->aspectRatio();
            })->save($path,100);

            $store->update([
                'store_logo' =>   $file_name,
            ]);
        }




        $store -> update([
            'store_name' => $request->store_name ,
            'store_email' => $request->store_email ,
            'store_mobile' => $request->store_mobile ,
            'country'=> $request->country ,
            'city'=> $request->city ,
            'state'=> $request->state ,
            'pincode'=> $request->pincode ,
            'address'=> $request->address ,
        ]);


        return redirect()->route('user.stores.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);

    }



    public function delete($id){

        $store = Store::findOrFail($id);

        $store->delete();

        return redirect()->route('user.stores.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success',
        ]);
    }



    public function default($id){

        $stores = Auth::user('web')->stores()->get();

        foreach ($stores as $value) {
            $value->default = '0' ;
            $value->save();
        };

        $store = Store::findOrFail($id);
        $store->update([
            'default' => 1 ,
        ]);

        return redirect()->route('user.stores.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);
    }




    public function change($id){

        $store = Store::findOrFail($id);

        Session::put('store',$store);

        return redirect()->route('user.dashboard')->with([
            'message' =>  'Store has changed',
            'alert-type' => 'success' ,
        ]);

    }
}
