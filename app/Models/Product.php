<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Illuminate\Support\Str;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    use HasFactory, HasTranslations, SoftDeletes, SearchableTrait;

    public $translatable = ['name','description'];

    protected $fillable = [
        'company_id', 'category_id', 'name', 'slug', 'description', 'price',
        'image', 'selling_price', 'compare_price', 'global_price', 'rating',
        'featured', 'status', 'image', 'shipping_time', 'sku', 'quantity',
        'link_xml', 'xml_product_id',
    ];


    protected $searchable = [

        'columns' => [
            'products.name' => 10,
        ],
    ];



    protected static function booted()
    {
        static::addGlobalScope('company',new CompanyScope);
    }


    public function scopeFilter(Builder $builder,$filters){

        $builder->when($filters['name'] ?? false,function ($builder,$value){
            $builder->where('products.name','LIKE', "%{$value}%");
        });
        $builder->when($filters['status'] ?? false,function ($builder,$value){
            $builder->where('products.status','=', $value);
        });
        // $builder->when($filters['category'] ?? false,function ($builder,$value){
        //     $builder->where('products.category_id','=', $value);
        // });
    }


    public function scopeActive(Builder $builder){
        $builder->where('status' , '=' , 'active');
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function images(){
        return $this->hasMany(ProductImage::class);
    }

    public function variants(){
        return $this->hasMany(Variant::class);
    }

    public function tags(){

        return $this->belongsToMany(Tag::class , 'product_tags' , 'product_id' , 'tag_id' , 'id' , 'id');
    }


    public function company(){
        return $this->belongsTo(Company::class)
        ->withDefault();
    }


    public function storeproduct(){
        return $this->hasOne(StoreProduct::class);
    }

    public function getImageUrlAttribute(){

        if(!$this->image){
            return 'https://icphso.org/global_graphics/default-store-350x350.jpg';
        }

        if (Str::startsWith($this->image,['http://' , 'https://'])) {
            return $this->image;
        }

        return asset('assets/product_images/' .$this->image);

    }




}
