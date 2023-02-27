<?php

namespace App\Models;

use App\Models\Scopes\CompanyScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Supplier extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $guard = 'supplier';

    protected $fillable = [
        'name',
        'company_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function scopeFilter(Builder $builder,$filters){

        $builder->when($filters['name'] ?? false,function ($builder,$value){
            $builder->where('suppliers.name','LIKE', "%{$value}%");
        });
        $builder->when($filters['email'] ?? false,function ($builder,$value){
            $builder->where('suppliers.email','LIKE', "%{$value}%");
        });
    }






    public function company(){
        return $this->belongsTo(Company::class);
    }



    public function profile(){
        return $this->hasOne(SupplierProfile::class,'supplier_id' , 'id')
        ->withDefault();
    }


    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }


    public function hasAbility($permissions)
    {
        $role = $this->role;

        if (!$role) {
            return false;
        }

        foreach ($role->permissions as $permission) {
            if (is_array($permissions) && in_array($permission, $permissions)) {
                return true;
            } else if (is_string($permissions) && strcmp($permissions, $permission) == 0) {
                return true;
            }
        }
        return false;
    }
}
