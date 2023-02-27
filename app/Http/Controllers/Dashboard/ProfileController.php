<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image as Image;

class ProfileController extends Controller
{
    public function index(){

        $admin = Auth::user('admin');

        return view('dashboard.profile.edit',[
            'admin' => $admin,
            'countries' => Countries::getNames(),
            'locales' => Languages::getNames(),
        ]);
    }


    public function update (Request $request){

        //return $request ;
        $request->validate([
            'first_name' => ['required' ,'string' , 'max:255'],
            'last_name' => ['required' ,'string' , 'max:255'],
            'birthday' => ['nullable' ,'date' , 'before:today'],
            'gender' => ['in:male,female'],
            'country' => ['required' ,'string' , 'size:2'],
            'city' => ['nullable' ,'string'],
            'state' => ['nullable' ,'string'],
            'street_address' => ['required', 'string', 'min:10', 'max:255'],
            'locale' => ['required' ,'string' ],
            'postal_code' => ['nullable' , 'integer' ],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png'],

        ]);

        $admin = $request->user('admin');

        if ($photo = $request->file('photo')) {
            if(File::exists('assets/profile_images/'.$admin->profile->photo) && $admin->profile->photo) {
                unlink('assets/profile_images/'.$admin->profile->photo);
                $admin->profile->photo = null ;
                $admin->profile->save();
            }
            $file_name = Str::slug($request->first_name).".".$photo->getClientOriginalExtension();
            $path = public_path('/assets/profile_images/' .$file_name);
            Image::make($photo->getRealPath())->resize(500,null,function($constraint){
                $constraint->aspectRatio();
            })->save($path,100);

            $input['photo'] =  $file_name;
            //return $input['photo'];
        }



        $input['first_name'] = $request-> first_name;
        $input['last_name'] = $request-> last_name;
        $input['birthday'] = $request-> birthday;
        $input['gender'] = $request-> gender;
        $input['country'] = $request-> country;
        $input['city'] = $request-> city;
        $input['street_address'] = $request->street_address ;
        $input['locale'] = $request-> locale;
        $input['postal_code'] = $request-> postal_code;
        $input['state'] = $request-> state;

        $admin->profile->fill($input)->save();

        return redirect()->route('admin.profile')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);

    }



    public function security (){

        $admin = Auth::user('admin');

        return view('dashboard.profile.security',[
            'admin' => $admin,
        ]);

    }



    public function security_update(Request $request){

        $admin = $request->user('admin');

        $request->validate([
            'username' => ['required','string',Rule::unique('admins','name')->ignore($admin->id),'max:255'],
            'email' => ['required','string','email',Rule::unique('admins','email')->ignore($admin->id)],
            'password' => ['nullable','confirmed',],
        ]);



        if ($request->password) {
            $admin->update([
                'name' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password) ,
            ]);
        }else{
            $admin->update([
                'name' => $request->username,
                'email' => $request->email,
            ]);
        }


        return redirect()->route('admin.profile.security')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);

    }
}
