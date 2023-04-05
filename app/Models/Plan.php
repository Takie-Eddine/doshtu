<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Plan extends Model
{
    use HasFactory, HasTranslations;


    public $translatable = ['name','description'];
    protected $fillable = [
        'name', 'description', 'annual_price', 'monthly_price', 'image',
    ];


    public function scopeAnnualPrice(Builder $builder){
        $builder->whereNotNull('annual_price');
    }

    public function scopeMonthlyPrice(Builder $builder){
        $builder->whereNotNull('monthly_price');
    }




    public function subscriptions(){
        return $this->hasMany(Subscription::class,'subscriptions');
    }


}
