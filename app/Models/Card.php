<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id', 'number', 'name', 'experation_date', 'cvv',
    ];



    public function user(){
        return $this->belongsTo(User::class);
    }
}
