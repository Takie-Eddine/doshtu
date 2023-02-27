<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintsController extends Controller
{
    public function index(){

        $complaints = Complaint::where('company_id',auth()->user()->company->id)->get();

        return view('supplier.complaints.index',compact('complaints'));

    }

    public function respond($id){

        $complaint = Complaint::find($id);

        if(!$complaint){

            return redirect()->route('supplier.complaints.index')->with([
                'message' => 'this user does not exist',
                'alert-type' => 'danger',
            ]);

        }

        return view('supplier.complaints.respond',compact('complaint'));
    }


    public function create(Request $request){

        $request->validate([
            'title' =>'required',
            'body' =>'required',
            'product_id' => 'required|exists:products,id',
            'store_id' => 'required|exists:stores,id',
        ]);
        $complaintresponse = Complaint::create([

            'title'=>$request->title,
            'body' =>$request->body,
            'store_id' =>$request->store_id,
            'product_id' =>$request->product_id,
            'company_id' =>auth()->user()->company_id,
        ]);


        return redirect()->route('supplier.complaints.index')->with([
            'message' => 'sent with success',
            'alert-type' => 'success',
        ]);

    }


    public function view($id){

        $complaint = Complaint::find($id);

        if(!$complaint){

            return redirect()->route('supplier.complaints.index')->with(['message' => 'this user does not exist',
            'alert-type' => 'danger',]);

        }

        return view('supplier.complaints.view',compact('complaint'));
    }



    public function newcomplaint(){

        $admin = Admin::first();

        return view('supplier.complaints.create',compact('admin'));
    }



    public function send(Request $request){

        $request->validate([
            'title' =>'required',
            'body' =>'required',
            'admin_id' => 'required|exists:admins,id',
        ]);

        $complaintresponse = Complaint::create([

            'title'=>$request->title,
            'body' =>$request->body,
            'company_id' =>auth()->user()->company_id,
            'admin_id'=>$request->admin_id
        ]);


        return redirect()->route('supplier.complaints.index')->with([
            'message' => 'sent with success',
            'alert-type' => 'success',
        ]);
    }

}
