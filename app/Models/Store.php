<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_name', 'store_email', 'store_mobile', 'store_logo',
        'country', 'city', 'state', 'pincode', 'address', 'status', 'default',
    ];



    public function users(){
        return $this->belongsToMany(User::class,'user_stores');
    }

    public function complaints(){
        return $this->hasMany(Complaint::class);
    }



    public function getImageUrlAttribute(){

        if(!$this->store_logo){
            return 'https://icphso.org/global_graphics/default-store-350x350.jpg';
        }

        if (Str::startsWith($this->store_logo,['http://' , 'https://'])) {
            return $this->store_logo;
        }

        return asset('assets/store_images/' .$this->store_logo);

    }
}
