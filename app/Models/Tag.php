<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    use HasFactory, HasTranslations, SearchableTrait;



    public $translatable = ['name'];

    protected $fillable = [
        'name', 'slug',
    ];
    public $timestamps = false;


    protected $searchable = [

        'columns' => [
            'tags.name' => 10,
        ],
    ];

    public function products(){

        return $this->belongsToMany(Product::class);
    }


}
