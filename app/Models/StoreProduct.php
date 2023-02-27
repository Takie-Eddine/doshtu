<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StoreProduct extends Model
{
    use HasFactory;

    //protected $primaryKey = ['product_id','store_id'];

    protected $fillable = [
        'product_id', 'name', 'store_id', 'slug', 'description', 'image', 'price', 'sku',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id' , 'id');
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'store_product_categories');
    }

    public function images(){
        return $this->hasMany(StoreProductImage::class);
    }

    public function variants(){
        return $this->hasMany(StoreVariant::class);
    }

    public function tags(){

        return $this->belongsToMany(Tag::class , 'store_product_tags' );
    }


    public function store(){
        return $this->belongsTo(Store::class);
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
