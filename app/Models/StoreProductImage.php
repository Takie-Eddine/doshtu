<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StoreProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'store_product_id', 'store_id',
    ];



    public function product(){
        return $this->belongsTo(StoreProduct::class);
    }


    public function getImageUrlAttribute(){

        if(!$this->name){
            return 'https://icphso.org/global_graphics/default-store-350x350.jpg';
        }

        if (Str::startsWith($this->name,['http://' , 'https://'])) {
            return $this->name;
        }

        return asset('assets/product_images/' .$this->name);

    }
}
