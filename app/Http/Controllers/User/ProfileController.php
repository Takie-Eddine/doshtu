<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(){

        $user = Auth::user('web');

        return view('user.profile.edit',[
            'user' => $user,
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

        $user = $request->user('web');

        if ($photo = $request->file('photo')) {

            if(File::exists('assets/profile_images/'.$user->profile->photo) && $user->profile->photo) {
                unlink('assets/profile_images/'.$user->profile->photo);
                $user->profile->photo = null ;
                $user->profile->save();
            }

            $file_name = Str::slug($request->first_name).".".$photo->getClientOriginalExtension();
            $path = public_path('/assets/profile_images/' .$file_name);
            Image::make($photo->getRealPath())->resize(500,null,function($constraint){
                $constraint->aspectRatio();
            })->save($path,100);

            $user->profile->update([
                'photo' => $file_name,
            ]);

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

        $user->profile->fill($input)->save();

        return redirect()->route('user.profile')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);

    }



    public function security (){

        $user = Auth::user('web');

        return view('user.profile.security',[
            'user' => $user,
        ]);

    }



    public function security_update(Request $request){

        $user = $request->user('web');

        $request->validate([
            'username' => ['required','string',Rule::unique('users','name')->ignore($user->id),'max:255'],
            'email' => ['required','string','email',Rule::unique('users','email')->ignore($user->id)],
            'password' => ['nullable','confirmed',],
        ]);



        if ($request->password) {
            $user->update([
                'name' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password) ,
            ]);
        }else{
            $user->update([
                'name' => $request->username,
                'email' => $request->email,
            ]);
        }


        return redirect()->route('user.profile.security')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);
}

}
