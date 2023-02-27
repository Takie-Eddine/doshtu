<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreVariant extends Model
{
    use HasFactory;



    protected $fillable = [
        'variant_id', 'product_id', 'store_id', 'price', 'quantity', 'image', 'sku',
    ];


    public function product(){
        return $this->belongsTo(StoreProduct::class);
    }


    public function attributes(){
        return $this->belongsToMany(Attribute::class, 'store_variant_attributes')
            ->withPivot(['value'])
            ->as('option') ;
    }
}
