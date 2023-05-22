<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Supplier;
use App\Models\Tag;
use App\Models\Variant;
use App\Models\VariantAttribute;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image as Image;
use SimpleXMLElement;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

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


        //$products1 = getXmlDetails('https://www.hapshoe.com/TicimaxCustomXml/60C1FBE427A7427CA0F3431BD6902D87');

        // $products2 = getXmlDetails('https://goktuggrup.com/TicimaxXml/E3743264826343C3AC321328AB97303D');

        // return $products2 ;
        // foreach ($products1->Urunler as  $value) {

        //     //return $value ;
        // }

        //return $products2 ;

        //return view('dashboard.products.test',compact('products1'));

        return view('dashboard.products.index',compact('products'));
    }


    public function add(){

        return view('dashboard.products.add',[
            'countries' => Countries::getNames(),
            'locales' => Languages::getNames(),
        ]);
    }

    public function store_xml(Request $request){

        // $request->validate([
        //     'company_name' => ['required' ,'string' , 'min:5' , 'max:255'],
        //     'email' => ['required', 'string', 'email', Rule::unique('companies','email')],
        //     'description' => ['required', 'string', 'min:30'],
        //     'mobile' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', Rule::unique('companies','mobile')] ,
        //     'country' => ['required' ,'string' , 'size:2'],
        //     'city' => ['nullable' ,'string'],
        //     'address' => ['required', 'string', 'min:10', 'max:255'],
        //     'username' => ['required' ,'string' , 'min:5' , 'max:255'],
        //     'email' => ['required', 'string', 'email', Rule::unique('suppliers','email')],
        //     'password' => ['required',  Rules\Password::defaults()],
        //     'link' => ['required','url'] ,
        // ]);


            $products = getXmlDetails($request->link);

            //return $products->Urunler ;

        $company = Company::create([
            'company_name' => $request->company_name,
            'email' =>$request->email,
            'description' =>$request->description,
            'mobile' =>$request->mobile,
            'country' =>$request->country,
            'city' =>$request->city,
            'address' =>$request->address,
        ]);

        $user = Supplier::create([
            'name' => $request->username,
            'email' => $request->user_email,
            'password' => Hash::make($request->password),
            'role_id' => 1 ,
            'company_id' => $company->id,
        ]);

        foreach ($products->Urunler as $product  ) {
            foreach ($product as $item) {

                //return $item->UrunSecenek->Secenek[0]->EkSecenekOzellik->Ozellik  ;
                $prod = Product::create([
                    'company_id' => $company->id,
                    'link_xml' => $request->link,
                    'xml_product_id' =>$item->UrunKartiID,
                    'name' => $item-> UrunAdi,
                    'slug' => Str::slug($item-> UrunAdi.$item->UrunKartiID),
                    'description' => $item->Aciklama,
                    'image'=> $item->Resimler->Resim[0],
                    'price'=>  (floatval($item ->UrunSecenek->Secenek[0]->IndirimliFiyat)/20 ),
                    'selling_price' => (floatval($item -> UrunSecenek->Secenek[0]->SatisFiyati)/20),
                    'sku' => $item -> UrunSecenek->Secenek[0]->StokKodu,
                    'quantity'=> $item -> UrunSecenek->Secenek[0]->StokAdedi,
                ]);

                if (!is_string($item->Resimler->Resim)) {
                    foreach ($item->Resimler->Resim as $resim) {
                        ProductImage::create([
                            'product_id' =>$prod->id,
                            'name' => $resim,
                        ]);
                    }
                }else{
                    ProductImage::create([
                        'product_id' => $prod->id ,
                        'name' => $item->Resimler->Resim ,
                    ]);
                }




                foreach ($item -> UrunSecenek->Secenek as $variant) {
                    $variant = Variant::create([
                        'product_id'=> $prod->id,
                        'price' => (floatval($variant->SatisFiyati) /20),
                        'selling_price' => (floatval($variant->IndirimliFiyat) /20),
                        'quantity' => $variant->StokAdedi,
                        'sku' => $variant->StokKodu,
                    ]);

                    // if (!is_null($variant->EkSecenekOzellik) ) {
                    //     foreach ($variant->EkSecenekOzellik as $Ozellik) {
                    //         $attributes = VariantAttribute::create([
                    //             'variant_id' => $variant->id,
                    //             'attribute_id' => 2,
                    //             'value' => $Ozellik,
                    //         ]);
                    //     }
                    // }
                }
            }




        }








    }


    public function create(){

        $tags = Tag::all();
        $categories = Category::parents()->get();
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



    public function edit_variant($id){

        $attributes = Attribute::all();
        $variant = Variant::findOrFail($id);

        // return $variant->attributes;


        return view('dashboard.products.variantedit',compact('variant','attributes'));
    }



    public function update_variant(Request $request, $id){


        //return $request->attribute_id[0];
        $request->validate([
            'attribute_id.*' => ['required', Rule::exists('attributes','id')],
            'value.*' => ['required','string'],
            'variants' => [
                            '*.attributes'=> ['nullable', Rule::exists('attributes','id')],
                            '*.variant'=> ['nullable', 'string']
                        ],
            'price' => ['required','numeric','between:0,99999999.99'],
            'sku' =>['required','string','min:6'],
            'quantity' => ['required','numeric'],
            'image' => ['nullable','mimes:jpg,jpeg,png'],

        ]);


        $variant = Variant::findOrFail($id);

        $product = Product::findOrFail($variant->product_id);

        if ($image = $request->file('image')) {

            if(File::exists('assets/product_images/'.$variant->image) && $variant->image) {
                unlink('assets/product_images/'.$variant->image);
                $variant->image = null ;
                $variant->save();
            }

            $file_name = Str::slug($product->getTranslation('name','en')).".".$image->getClientOriginalExtension();
                $path = public_path('/assets/product_images/' .$file_name);
                Image::make($image->getRealPath())->resize(500,null,function($constraint){
                    $constraint->aspectRatio();
                })->save($path,100);

                $variant->update([
                    'image' => $file_name,
                ]);
        }

        $variant->update([
            'price' => $request->price ,
            'sku' =>$request->sku ,
            'quantity' =>$request->quantity ,
        ]);

        $variant_attributes = VariantAttribute::where('variant_id',$variant->id)->get();


        foreach ($variant_attributes as $variant_attribute) {

            for ($i=0; $i <count($request->attribute_id) ; $i++) {
                $variant_attribute->update([
                    'variant_id' => $variant->id,
                ]);


            }

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
