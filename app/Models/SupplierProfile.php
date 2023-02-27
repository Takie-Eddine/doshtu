<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SupplierProfile extends Model
{
    use HasFactory;

    protected $primaryKey = 'supplier_id';


    protected $fillable = [
        'supplier_id' , 'first_name' , 'last_name' , 'birthday' , 'gender' , 'street_address' ,
        'photo' , 'city' , 'state' , 'postal_code' , 'country' , 'locale' ,
    ];



    public function getImageUrlAttribute(){

        if(!$this->photo){
            return 'https://icphso.org/global_graphics/default-store-350x350.jpg';
        }

        if (Str::startsWith($this->photo,['http://' , 'https://'])) {
            return $this->photo;
        }

        return asset('assets/profile_images/' .$this->photo);

    }


    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id' , 'id');
    }
}
