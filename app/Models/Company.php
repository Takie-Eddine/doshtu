<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;
use Nicolaslopezj\Searchable\SearchableTrait;

class Company extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia,  SoftDeletes, SearchableTrait;

    protected $fillable = [
        'company_name', 'mobile', 'office_mobile', 'email', 'description', 'address', 'website', 'country', 'city',
        'state', 'pincode', 'is_active', 'logo', 'facebook', 'instagram', 'twitter', 'youtube', 'telegram', 'linkedin',
    ];

    protected $searchable = [

        'columns' => [
            'companies.company_name' => 10,
        ],
    ];


    public function scopeFilter(Builder $builder,$filters){

        $builder->when($filters['name'] ?? false,function ($builder,$value){
            $builder->where('companies.company_name','LIKE', "%{$value}%");
        });
        $builder->when($filters['status'] ?? false,function ($builder,$value){
            $builder->where('companies.is_active','=', $value);
        });
    }


    public function suppliers(){
        return $this->hasMany(Supplier::class);
    }



    public function getImageUrlAttribute(){

        if(!$this->logo){
            return 'https://icphso.org/global_graphics/default-store-350x350.jpg';
        }

        if (Str::startsWith($this->logo,['http://' , 'https://'])) {
            return $this->logo;
        }

        return asset('assets/company_logos/' .$this->logo);

    }

}
