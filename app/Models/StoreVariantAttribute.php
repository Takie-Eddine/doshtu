<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreVariantAttribute extends Model
{
    use HasFactory;

    public $table = 'store_variant_attributes';
    public $timestamps = false;
    protected $fillable = [
        'value', 'variant_id', 'attribute_id',
    ];
}
