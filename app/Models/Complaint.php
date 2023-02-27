<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Complaint extends Model
{
    use HasFactory;


    protected $fillable = [
        'title', 'body', 'product_id', 'store_id', 'company_id', 'admin_id',
    ];


    public function store(){
        return $this->belongsTo(Store::class);
    }


    public function product(){
        return $this->belongsTo(Product::class);
    }


    public function company(){
        return $this->belongsTo(Company::class);
    }


}
