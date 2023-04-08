<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class TagController extends Controller
{

    public function index(){

        $tags = Tag::paginate();

        return view('dashboard.tags.index',compact('tags'));
    }


    public function create(){

        return view('dashboard.tags.create');
    }


    public function store(Request $request){

        $request->validate([
            'name_en' => ['required', 'string', Rule::unique('tags','slug')],
            'name_ar' => ['required', 'string', Rule::unique('tags','slug')],
        ]);

        Tag::create([
            'name' => [
                        'en' => $request->name_en,
                        'ar' => $request->name_ar,
                    ],
            'slug' =>  Str::slug($request->name_en),
        ]);


        return redirect()->route('admin.tags.index')->with([
            'message' => 'Created successfully',
            'alert-type' => 'success',
        ]);

    }

    public function edit($id){

        $tag = Tag::findOrFail($id);

        return view('dashboard.tags.edit',compact('tag'));
    }


    public function update(Request $request, $id){

        $request->validate([
            'name_en' => ['required', 'string', Rule::unique('tags','slug')->ignore($id)],
            'name_ar' => ['required', 'string', Rule::unique('tags','slug')->ignore($id)],
        ]);


        $tag = Tag::findOrFail($id);

        $tag->update([
            'name' => [
                'en' => $request->name_en,
                'ar' => $request->name_ar,
            ],
            'slug' =>  Str::slug($request->name_en),
        ]);


        return redirect()->route('admin.tags.index')->with([
            'message' => 'Updated successfully',
            'alert-type' => 'success',
        ]);

    }



    public function destroy($id){

        $tag = Tag::findOrFail($id);
        $tag->delete();
        return redirect()->back()->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success',
        ]);
    }

}
