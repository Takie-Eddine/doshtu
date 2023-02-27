<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ComplaintsController extends Controller
{


    public function index(){

        if (!Auth::user()->parent) {
            $stores = Auth::user('web')->stores;

            $complaints = [];

            foreach ($stores as $value) {
                $complaints = Complaint::where('store_id',$value->id)->get();
            }

        }else{
            $complaints = Complaint::where('store_id',Auth::user()->stores->id)->get();
        }


        return view('user.complaints.index',compact('complaints'));
    }




    public function view($id){
        $complaint = Complaint::findOrFail($id);
        return view('user.complaints.view',compact('complaint'));
    }




    public function newcomplaint(){

        return view('user.complaints.create');
    }




    public function send(Request $request){

        $request->validate([
            'product_name' => ['nullable','string',Rule::exists('products','name')],
            'complaint_type' => ['required','string','in:doshtu,product'],
            'title' => ['required','string','min:4'],
            'body' => ['required','string','min:20'],
        ]);



        // if($request->product_name){
        //     Complaint::create([
        //         ''

        //     ]);

        // }else {

        // }


    }

}
