<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str ;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\File;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //$request = request();
        $categories = Category::Parents()->select('id', 'name','status','image','created_at','parent_id')->with(['children' => function ($q) {
                $q->select('id', 'name','status','image','created_at','parent_id');
                $q->with(['children' => function ($qq) {
                    $qq->select('id', 'name','status','image','created_at','parent_id');
                    $qq->with(['children' =>function($qqq){
                        $qqq->select('id', 'name','status','image','created_at','parent_id');
                        $qqq->with(['children' =>function($qqqq){
                            $qqqq->select('id', 'name','status','image','created_at','parent_id');
                        }]);
                    }]);
                }]);
            }])->when(request()->keyword != null,function ($query){
                $query->search(request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereStatus(\request()->status);
            })
            ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
            ->paginate(\request()->limit_by ?? 10);


            //return $categories;
        return view('dashboard.categories.index',compact('categories'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('dashboard.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {



        //return  $translation ;

        //return $request ;
        $request->validate([

            'tr' => ['required', 'string' ,'min:4', 'unique:categories,name'] ,
            'ar' => ['required', 'string', 'min:4','unique:categories,name'] ,
            'en' => ['required', 'string', 'min:4','unique:categories,name'] ,
            'parent_id' => ['nullable' , 'int' , 'exists:categories,id'] ,
            'description' => ['nullable','string' , 'min:10'] ,
            'image' => ['nullable', 'mimes:jpg,jpeg,png'] ,
            'status' => ['required' , 'in:active,archived'] ,

        ]);

        if ($photo = $request->file('image')) {
            $file_name = Str::slug($request->en).".".$photo->getClientOriginalExtension();
            $path = public_path('/assets/category_images/' .$file_name);
            Image::make($photo->getRealPath())->resize(500,null,function($constraint){
                $constraint->aspectRatio();
            })->save($path,100);

            $request->image =  $file_name;
            //return $input['photo'];
        }

        $category = Category::whereSlug(Str::slug($request->en))->first();

        if($category){
            return redirect()->back()->with([
                'message' => 'This category exists. please change ',
                'alert-type' => 'danger',
            ]);
        }



        $translation = [] ;

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode=> $properties) {
            $translation  =  array_merge ($translation, [$localeCode => $request->$localeCode] );
        }


        try{

            $category = Category::create([
                'name' => $translation,
                'slug' => Str::slug($request->en),
                'parent_id' => $request->parent_id,
                'description' => $request->description,
                'image' => $request->image,
                'status' =>$request->status,
            ]);

            return redirect()->route('admin.categories.index')->with([
                'message' => 'Created successfully',
                'alert-type' => 'success',
            ]);

        }catch(Exception $ex){

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

        $childIds = getAllChildIds($category);

        return $childIds ;

        $childIds[] = $category;



        $products = collect();

        foreach ($childIds as $childId) {
            $products = $products->merge( $childId->products()->get());
        }


        // return $products ;


        return view('dashboard.categories.show',compact('category','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);


        if (!$category) {
            return redirect()->route('dashboard.categories.index')->with([
                'message' => 'Not found',
                'alert-type' => 'danger',
            ]);
        }

        $categories = Category::where('id','<>',$id)
            ->where(function($query) use($id){
                $query->whereNull('parent_id')
                ->orWhere('parent_id','<>',$id);
            })->get();

        return view('dashboard.categories.edit',compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'ar' => ['required', 'string' ,'min:4', 'unique:categories,name'] ,
            'en' => ['required', 'string', 'min:4','unique:categories,name'] ,
            'tr' => ['required', 'string', 'min:4','unique:categories,name'] ,
            'parent_id' => ['nullable' , 'int' , 'exists:categories,id'] ,
            'description' => ['nullable','string' , 'min:10'] ,
            'image' => ['nullable', 'mimes:jpg,jpeg,png'] ,
            'status' => ['required' , 'in:active,archived'] ,

        ]);

        $category = Category::findOrFail($id);

        try {

            DB::beginTransaction();

            if ($photo = $request->file('image')) {
                if(File::exists('assets/category_images/'.$category->image) && $category->image) {
                    unlink('assets/category_images/'.$category->image);
                    $category->image = null ;
                    $category->save();
                }
                $file_name = Str::slug($request->en).".".$photo->getClientOriginalExtension();
                $path = public_path('/assets/category_images/' .$file_name);
                Image::make($photo->getRealPath())->resize(500,null,function($constraint){
                    $constraint->aspectRatio();
                })->save($path,100);

                $category->update([
                    'image' => $file_name,
                ]) ;
            }

            $translation = [] ;

            foreach (LaravelLocalization::getSupportedLocales() as $localeCode=> $properties) {
                $translation  =  array_merge ($translation, [$localeCode => $request->$localeCode] );
            }


            $category->update([
                'name' => $translation ,
                'slug' => Str::slug($request->en),
                'parent_id' => $request->parent_id,
                'description' => $request->description,
                'status' =>$request->status,
            ]);


            return redirect()->route('admin.categories.index')->with([
                'message' => 'Updated successfully',
                'alert-type' => 'success',
            ]);

            DB::commit();

        }catch(Exception $ex){
            DB::rollback();

            return redirect()->back()->with($ex->getMessage());

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success',
        ]);

    }



    public function trash()
    {
        $categories = Category::onlyTrashed()
        ->when(request()->keyword != null,function ($query){
            $query->search(request()->keyword);
        })
        ->when(\request()->status != null, function ($query) {
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
        ->paginate(\request()->limit_by ?? 10);;
        return view('dashboard.categories.trash',compact('categories'));
    }


    public function restore(Request $request ,$id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.categories.trash')->with([
            'message' => 'Category restored',
            'alert-type' => 'success',
        ]);
    }



    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if(File::exists('assets/category_images/'.$category->image) && $category->image) {
            unlink('assets/category_images/'.$category->image);
        }

        return redirect()->route('admin.categories.trash')->with([
            'message' => 'Category deleted forever',
            'alert-type' => 'success',
        ]);
    }




}
