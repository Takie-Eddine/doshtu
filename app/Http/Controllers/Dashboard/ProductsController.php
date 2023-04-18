<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use App\Models\Variant;
use App\Models\VariantAttribute;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as Image;

class ProductsController extends Controller
{
    public function index(){

        $request = request();

        $products = Product::with(['categories','company','images'])
        ->when(request()->keyword != null,function ($query){
            $query->search(request()->keyword);
        })
        ->when(\request()->status != null, function ($query) {
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
        ->paginate(\request()->limit_by ?? 10);



        return view('dashboard.products.index',compact('products'));
    }


    public function create(){

        $tags = Tag::all();
        $categories = Category::all();
        $companies = Company::all();
        return view('dashboard.products.create',compact('tags','categories','companies'));

    }


    public function store(Request $request){

        //return $request;
        $request->validate([
            'name_ar' => ['required', 'string', 'min:4', 'max:255'],
            'name_en' => ['required', 'string', 'min:4', 'max:255'],
            'description_ar' => ['required', 'min:50'],
            'description_en' => ['required', 'min:50'],
            'tags' => ['required', 'array', 'min:1'],
            'category' => ['required', Rule::exists('categories','id'), 'array', 'min:1'],
            'photo' => 'nullable',
            'photo.*'=> 'mimes:jpg,jpeg,png',
            'image' => 'nullable|array|min:1',
            'image.*' => 'mimes:jpg,jpeg,png',
            'price' => ['required','numeric','between:0,99999999.99'],
            'selling_price' => ['nullable', 'numeric','between:0,99999999.99'],
            'global_price' => ['nullable', 'numeric','between:0,99999999.99'],
            'compare_price' => ['nullable', 'numeric','between:0,99999999.99'],
            'company' => ['required', Rule::exists('companies','id')],
            'shipping_time' => ['required', 'numeric'],
            'sku' => 'required|min:3|max:50',
            'quantity' => 'nullable',
        ]);

        try{
            DB::beginTransaction();

            $file_name = null;
            if ($request->file('photo')) {

                $file_name = Str::slug($request->name_en).".".rand(00,99).".".$request->photo->getClientOriginalExtension();
                    $path = public_path('/assets/product_images/' .$file_name);
                    Image::make($request->photo->getRealPath())->resize(500,null,function($constraint){
                        $constraint->aspectRatio();
                    })->save($path,100);
            }

            if (!$request->selling_price) {

                $request->selling_price = ((($request->price)*25)/100 + $request->price);
            }

            $product = Product::create([
                'company_id' => $request->company,
                //'category_id' => $request-> category,
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar] ,
                'slug' => Str::slug($request->name_en.rand(0000,9999)) ,
                'description' => ['en' => $request->description_en, 'ar' => $request->description_ar],
                'image' => $file_name,
                'price' => $request->price ,
                'selling_price' => $request->selling_price ,
                'compare_price' => $request->compare_price ,
                'global_price' => $request->global_price ,
                'status' => 'active' ,
                'shipping_time' => $request->shipping_time ,
                'sku' => $request->sku ,
                'quantity' => $request->quantity ,
            ]);
            $product->categories()->sync($request->category);

            $tags = $request->post('tags');
            $tag_ids = [];
            $saved_tags = Tag::all();

            foreach ($tags as $item) {

                $slug = Str::slug($item);
                $tag = $saved_tags->where('slug', $slug)->first();

                if (!$tag) {
                    $tag = Tag::create([
                        'name' => $item,
                        'slug' => $slug,
                    ]);
                }
                $tag_ids[] = $tag->id;
            };
            $product->tags()->sync($tag_ids);



            if ($request->image && $request->image >0) {

                foreach ($request->image as $value) {
                    $file_name = Str::slug($request->name_en).".".rand(00,99).".".$value->getClientOriginalExtension();
                    $path = public_path('/assets/product_images/' .$file_name);
                    Image::make($value->getRealPath())->resize(500,null,function($constraint){
                        $constraint->aspectRatio();
                    })->save($path,100);
                    ProductImage::create([
                        'product_id' =>$product->id,
                        'name' => $file_name,
                    ]);
                };
            };


            DB::commit();
            return redirect()->route('admin.products.index')->with([
                'message' => 'Created successfully',
                'alert-type' => 'success',
            ]);

        }catch(Exception $ex){
            DB::rollback();
            return redirect()->route('admin.products.index')->with($ex->getMessage());
        }


    }



    public function show (Product $product){

        //return $product->variants[0]->attributes;
        return view('dashboard.products.show',compact('product'));

    }


    public function edit($id){

        $product = Product::findOrFail($id);
        $categories = Category::all();
        $companies = Company::all();
        $tags = Tag::all();

        return view('dashboard.products.edit', compact('product', 'tags', 'categories', 'companies'));
    }



    public function update(Request $request, $id){


        $request->validate([
            'name_ar' => ['required', 'string', 'min:4', 'max:255'],
            'name_en' => ['required', 'string', 'min:4', 'max:255'],
            'description_ar' => ['required', 'min:50'],
            'description_en' => ['required', 'min:50'],
            'tags' => ['required', 'array', 'min:1'],
            'category' => ['required', Rule::exists('categories','id'), 'array', 'min:1'],
            'image' => 'nullable|array|min:1',
            'image.*' => 'mimes:jpg,jpeg,png',
            'photo' => 'nullable',
            'photo.*'=> 'mimes:jpg,jpeg,png',
            'price' => ['required','numeric','between:0,99999999.99'],
            'selling_price' => ['nullable','numeric', 'between:0,99999999.99'],
            'global_price' => ['nullable','numeric', 'between:0,99999999.99'],
            'compare_price' => ['nullable','numeric', 'between:0,99999999.99'],
            'company' => ['required', Rule::exists('companies','id')],
            'shipping_time' => ['required', 'numeric'],
            'sku' => 'required|min:3|max:50',
            'quantity' => 'nullable',
        ]);

        $product = Product::findOrFail($id);
        try{
            DB::beginTransaction();

            $file_name = null;

            if ($request->file('photo')) {
                if(File::exists('assets/product_images/'.$product->image) && $product->image) {
                    unlink('assets/product_images/'.$product->image);
                    $product->image = null ;
                    $product->save();
                }
                $file_name = Str::slug($request->name_en).".".rand(00,99).".".$request->photo->getClientOriginalExtension();
                    $path = public_path('/assets/product_images/' .$file_name);
                    Image::make($request->photo->getRealPath())->resize(500,null,function($constraint){
                        $constraint->aspectRatio();
                    })->save($path,100);
                $product->update([
                    'image' => $file_name,
                ])  ;
            }

            $product->update([
                'company_id' => $request->company,
                //'category_id' => $request-> category,
                'name' => ['en' => $request->name_en, 'ar' => $request->name_ar] ,
                'slug' => Str::slug($request->name_en.rand(0000,9999)) ,
                'description' => ['en' => $request->description_en, 'ar' => $request->description_ar],
                //'image' => $file_name,
                'price' => $request->price ,
                'selling_price' => $request->selling_price ,
                'compare_price' => $request->compare_price ,
                'global_price' => $request->global_price ,
                'status' => 'active' ,
                'shipping_time' => $request->shipping_time ,
                'sku' => $request->sku ,
                'quantity' => $request->quantity ,
            ]);
            $product->categories()->sync($request->category);

            $tags = $request->post('tags');
            $tag_ids = [];
            $saved_tags = Tag::all();

            foreach ($tags as $item) {

                $slug = Str::slug($item);
                $tag = $saved_tags->where('slug', $slug)->first();

                if (!$tag) {
                    $tag = Tag::create([
                        'name' => $item,
                        'slug' => $slug,
                    ]);
                }
                $tag_ids[] = $tag->id;
            };
            $product->tags()->sync($tag_ids);



            if ($request->image && $request->image >0) {

                foreach ($request->image as $value) {
                    $file_name = Str::slug($request->name_en).".".rand(00,99).".".$value->getClientOriginalExtension();
                    $path = public_path('/assets/product_images/' .$file_name);
                    Image::make($value->getRealPath())->resize(500,null,function($constraint){
                        $constraint->aspectRatio();
                    })->save($path,100);
                    ProductImage::create([
                        'product_id' =>$product->id,
                        'name' => $file_name,
                    ]);
                };
            };


            DB::commit();
            return redirect()->back()->with([
                'message' => 'Created successfully',
                'alert-type' => 'success',
            ]);

        }catch(Exception $ex){
            DB::rollback();
            return redirect()->route('admin.products.index')->with($ex->getMessage());
        }


    }




    public function destroy($id){

        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success',
        ]);
    }


    public function trash()
    {
        $products = Product::onlyTrashed()->when(request()->keyword != null,function ($query){
            $query->search(request()->keyword);
        })
        ->when(\request()->status != null, function ($query) {
            $query->whereStatus(\request()->status);
        })
        ->orderBy(\request()->sort_by ?? 'id', \request()->order_by ?? 'desc')
        ->paginate(\request()->limit_by ?? 10);;
        return view('dashboard.products.trash',compact('products'));
    }


    public function restore(Request $request ,$id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.products.trash')->with([
            'message' => 'Product Restored',
            'alert-type' => 'success',
        ]);
    }



    public function add_variant(Product $product){

        $attributes = Attribute::all();

        $variants = Variant::where('product_id',$product->id)->get();

        return view('dashboard.products.variant',compact('product','attributes','variants'));
    }



    public function store_variant(Request $request){

        //return $request->variants;

        $request->validate([
            'variants' => [
                            '*.attributes'=> ['required', Rule::exists('attributes','id')],
                            '*.variant'=> ['required', 'string']
                        ],
            'price' => ['nullable','numeric','between:0,99999999.99'],
            'sku' =>['nullable','string','min:6'],
            'quantity' => ['nullable','numeric'],
            'image' => ['nullable','mimes:jpg,jpeg,png'],
        ]);

        $product = Product::findOrFail($request->id);

        try{
            DB::beginTransaction();

            if (!$request->price) {
                $request->price = $product->price;
            };
            if ($image = $request->file('image')) {

                $file_name = Str::slug($product->getTranslation('name','en')).".".$image->getClientOriginalExtension();
                $path = public_path('/assets/product_images/' .$file_name);
                Image::make($image->getRealPath())->resize(500,null,function($constraint){
                    $constraint->aspectRatio();
                })->save($path,100);
                $request->image = $file_name;
            }


            $varriant = Variant::create([
                'product_id' => $product->id,
                'price' => $request->price ,
                'sku' =>$request->sku ,
                'quantity' =>$request->quantity ,
                'image' => $request->image ,
            ]);

            $attributes_id = [];

            foreach ($request->variants as $item) {
                $attributes_id = $item['attributes'];

                VariantAttribute::create([
                    'variant_id'=> $varriant->id,
                    'attribute_id'=> $item['attributes'],
                    'value' => $item['variant'],
                ]);
            };

            DB::commit();
            // $product->attributes()->sync($attributes_id);

            return redirect()->back()->with([
                'message' => 'Varriant Added',
                'alert-type' => 'success',
            ]);

        }catch(Exception $ex){

            DB::rollback();
            return redirect()->back()->with($ex->getMessage());
        }

    }


    public function delete_variant($id){

        try{
            $variant = Variant::findOrFail($id);



            DB::beginTransaction();

            $variant_attributes = VariantAttribute::where('variant_id',$variant->id)->delete();
            $variant->delete();
            DB::commit();
            return redirect()->back()->with([
                'message' => 'Deleted successfully',
                'alert-type' => 'success',
            ]);

        }catch(Exception $ex){
            DB::rollback();
            return redirect()->back()->with([
                'message' => 'There is problem',
                'alert-type' => 'errors',
            ]);
        }


    }



    public function activate($id){

        $product = Product::findOrFail($id);


        if ($product->status === 'active' ) {
            $product->update([
                'status'=> 'inactive',
            ]);
            return redirect()->back()->with([
                'message' => 'Changed successfully',
                'alert-type' => 'success',
            ]);
        }

        if ($product->status ==='inactive' ) {
            $product->update([
                'status'=> 'active',
            ]);
            return redirect()->back()->with([
                'message' => 'Changed successfully',
                'alert-type' => 'success',
            ]);
        }


    }


}
