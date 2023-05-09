<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class VariantAttribute extends Pivot
{
    use HasFactory;


    public $table = 'variant_attributes';
    public $timestamps = false;

    protected $fillable = [
        'value', 'variant_id', 'attribute_id',
    ];


}
