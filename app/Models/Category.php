<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory , HasTranslations , SoftDeletes, SearchableTrait;


    public $translatable = ['name'];

    protected $fillable = [
        'name' , 'parent_id' , 'description' , 'image' , 'status' , 'slug'
    ];

    protected $searchable = [

        'columns' => [
            'categories.name' => 10,
            'categories.slug' => 10,
        ],
    ];


    public function scopeActive(Builder $builder){
        $builder->where('status','=' ,'active');
    }

    public function scopeParents($query){
        return $query -> whereNull('parent_id');
    }

    public function scopeChild($query){
        return $query -> whereNotNull('parent_id');
    }



    public function scopeFilter(Builder $builder,$filters){

        $builder->when($filters['name'] ?? false,function ($builder,$value){
            $builder->where('categories.name','LIKE', "%{$value}%");
        });
        $builder->when($filters['status'] ?? false,function ($builder,$value){
            $builder->where('categories.status','=', $value);
        });
    }


    public function getImageUrlAttribute(){

        if(!$this->image){
            return 'https://icphso.org/global_graphics/default-store-350x350.jpg';
        }

        if (Str::startsWith($this->image,['http://' , 'https://'])) {
            return $this->image;
        }

        return asset('assets/category_images/' .$this->image);

    }




    public function parent(){
        return $this->belongsTo(Category::class, 'parent_id','id')
        ->withDefault([
            'name' => '__'
        ]);
    }

    public function children(){
        return $this->hasMany(Category::class,'parent_id','id');
    }


    public function products(){
        return $this->belongsToMany(Product::class, 'product_categories');
    }
}
