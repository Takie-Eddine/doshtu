<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paypal extends Model
{
    use HasFactory;


    protected $fillable = [
        'subscription_id', 'transaction_id', 'paypal_email', 'created_time',
    ];
}
