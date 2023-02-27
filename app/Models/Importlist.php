<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Importlist extends Pivot
{
    use HasFactory;


    protected $table = 'importlists';

    protected $fillable = [
        'product_id', 'store_id',
    ];



    public function products(){
        return $this->belongsTo(Product::class,'product_id');
    }





}
