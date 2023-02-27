<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;


    protected $fillable = [
        'product_id', 'price', 'image', 'quantity', 'sku',
    ];


    public function product(){
        return $this->belongsTo(Product::class);
    }


    public function attributes(){
        return $this->belongsToMany(Attribute::class, 'variant_attributes')
            ->withPivot(['value'])
            ->as('option') ;
    }

}
