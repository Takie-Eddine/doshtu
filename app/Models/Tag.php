<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasFactory, HasTranslations;



    public $translatable = ['name'];

    protected $fillable = [
        'name', 'slug',
    ];
    public $timestamps = false;

    public function products(){

        return $this->belongsToMany(Product::class);
    }


}
