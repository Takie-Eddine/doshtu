<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Spatie\Translatable\HasTranslations;

class Attribute extends Model
{
    use HasFactory, HasTranslations, SearchableTrait;


    public $translatable = ['name'];

    protected $fillable = [
        'name',
    ];
    protected $searchable = [

        'columns' => [
            'attributes.name' => 10,
        ],
    ];



}
