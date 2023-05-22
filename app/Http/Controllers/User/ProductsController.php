<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Importlist;
use App\Models\Product;
use App\Models\StoreProduct;
use App\Models\StoreProductImage;
use App\Models\StoreVariant;
use App\Models\StoreVariantAttribute;
use App\Models\Tag;
use App\Models\Variant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str ;

class ProductsController extends Controller
{
    public function index(){

        $request = request();

        //return $request;

        $products = Product::with('categories')
                            ->active()
                            ->filter($request->query())
                            ->paginate(30);

        $categories = Category::parents()->get();

        return view('user.products.index',compact('products','categories'));
    }



    public function importlist(){

        $products = Importlist::where('store_id',Session::get('store')->id)->get();
        return view('user.products.importlist',compact('products'));

    }



    public function importliststore($slug){

        $product = Product::where('slug',$slug)->first();

        if (!$product) {
            return redirect()->back()->with([
                'message' => 'This product does not exist',
                'alert-type' => 'danger',
            ]);
        }

        $importlist = Importlist::where('product_id',$product->id)->where('store_id',Session::get('store')->id)->first();
        //return $importlist ;

        if (!$importlist) {
            Importlist::create([
                'product_id' => $product->id,
                'store_id' => Session::get('store')->id,
            ]);
            return redirect()->back()->with([
                'message' => 'Added successfully',
                'alert-type' => 'success',
            ]);
        }
        return redirect()->back()->with([
            'message' => 'Already exist',
            'alert-type' => 'success',
        ]);

    }



    public function remove_importlist($id){

        $importlist = Importlist::findOrFail($id);
        $importlist->delete();

        return redirect()->back()->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success',
        ]);

    }



    public function details($slug){

        $product = Product::with('categories','variants','images','tags')->where('slug',$slug)->first();

        $product_categories_ids = $product->categories->pluck('id');

        $related_products = Product::whereHas('categories',function ($cat) use($product_categories_ids){
            $cat-> whereIn('categories.id',$product_categories_ids);
        }) -> limit(20) -> latest() -> get();

        return view('user.products.details',compact('product','related_products'));
    }


    public function pushtostore($slug){

        $product = Product::with('categories','tags','images')->where('slug',$slug)->first();
        if (!$product) {
            return redirect()->back()->with([
                'message' => 'This product does not exist',
                'alert-type' => 'danger',
            ]);
        }

        $tags = Tag::all();
        $categories = Category::all();


        return view('user.products.product',compact('product','tags','categories'));
    }



    public function push(Request $request){

        $request->validate([
            'product_id' => ['required',Rule::exists('products','id')] ,
            'name' => ['required', 'string', 'min:4', 'max:255'] ,
            'description' => ['required', 'min:50'] ,
            'tags' => ['required', 'array', 'min:1'] ,
            'categories' => ['required', Rule::exists('categories','id'), 'array', 'min:1'] ,
            'selling_price' => ['required','numeric'] ,
            'sku' => ['required','min:3'] ,
        ]);

        try {
            DB::beginTransaction();
            $product = Product::findOrFail($request->product_id);

            $variant = StoreVariant::where('product_id',$product->id)->where('store_id',Session::get('store')->id)->first();

            if (!$variant) {
                $variants = $product->variants()->with('attributes')->get();

                foreach ($variants as $value) {
                    $store_variant = StoreVariant::create([
                        'variant_id' => $value->id,
                        'product_id' => $value->product_id,
                        'store_id' => Session::get('store')->id,
                        'price' => $value->price,
                        'quantity' => $value->quantity,
                        'sku' => $value->sku,
                        'image' => $value->image,
                    ]);

                    foreach ($value->attributes as $item) {
                        StoreVariantAttribute::create([
                            'variant_id' => $store_variant->id,
                            'attribute_id' => $item->option->attribute_id,
                            'value' => $item->option->value,
                        ]);
                    }

                }
            }

            $store_product = StoreProduct::updateOrcreate([
                'product_id' => $request->product_id,
                'store_id' => Session::get('store')->id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'price' => $request->selling_price,
                'sku' => $request->sku,
                'image' => $product->image,
            ]);

            $store_product->categories()->sync($request->categories);
            $store_product->tags()->sync($request->tags);

            $images = $product->images;

            foreach ($images as $image) {
                StoreProductImage::create([
                    'store_product_id' => $store_product->id,
                    'store_id' => Session::get('store')->id,
                    'name' => $image->name
                ]);
            }

            DB::commit();

            return redirect()->route('user.products.products')->with([
                'message' => 'Added successfully',
                'alert-type' => 'success',
            ]);

        } catch (\Exception $ex) {
            DB::rollback();

            return redirect()->back()->with([
                'message' => $ex->getMessage(),
                'alert-type' => 'danger',
            ]);
        }

    }



    public function variant($slug){

        $product = Product::where('slug',$slug)->first();
        if (!$product) {
            return redirect()->back()->with([
                'message' => 'This product does not exist',
                'alert-type' => 'danger',
            ]);
        }

        $variants = $product->variants()->with('attributes')->get() ;


        //$variants = Variant::where('product_id',$product->id)->get();
        if (!$variants) {
            return redirect()->back()->with([
                'message' => 'This product does not have a variants',
                'alert-type' => 'danger',
            ]);
        }
        return view('user.products.variants',compact('variants','product'));

    }



    public function pushvariant(Request $request){

        $request->validate([
            'product_id' => ['required',Rule::exists('products','id')],
            'id' => ['nullable','array','min:1'],
            'sku' => ['nullable','array','min:1'],
            'price' => ['nullable','array','min:1'],
            'quantity' => ['nullable','array','min:1'],
        ]);

        try {
            DB::beginTransaction();

            for ($i=0; $i <count($request->id) ; $i++) {
                $variant = Variant::findOrFail($request->id[$i]);
                $store_variant = StoreVariant::create([
                    'variant_id' => $request->id[$i],
                    'product_id' => $request->product_id,
                    'store_id' => Session::get('store')->id,
                    'price' => $request->price[$i],
                    'sku' => $request->sku[$i],
                    'quantity' => $request->quantity[$i],
                    'image' => $variant->image,
                ]);

                foreach ($variant->attributes as  $item) {
                    StoreVariantAttribute::create([
                        'variant_id' => $store_variant->id,
                        'attribute_id' => $item->option->attribute_id,
                        'value' => $item->option->value,
                    ]);
                }

            }

            DB::commit();

            return redirect()->back()->with([
                'message' => 'Added successfully',
                'alert-type' => 'success',
            ]);
        } catch (Exception $ex) {
            DB::rollback();
            return redirect()->back()->with([
                'message' => $ex->getMessage(),
                'alert-type' => 'danger',
            ]);
        }
    }



    public function product_instore(){

        $products = StoreProduct::where('store_id',Session::get('store')->id)->get();

        return view('user.products.productsinstore',compact('products'));
    }


    public function remove_product_instore(Request $request){

        $request->validate([
            'product_id' => ['required',Rule::exists('store_products','product_id')],
        ]);

        $product =  StoreProduct::where('store_id',Session::get('store')->id)->where('product_id',$request->product_id)->first();

        return $product ;
        $product->delete();

        return redirect()->back()->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success',
        ]);

    }




}
