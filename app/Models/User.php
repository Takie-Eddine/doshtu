<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Nicolaslopezj\Searchable\SearchableTrait;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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

    protected $searchable = [

        'columns' => [
            'users.name' => 10,
            'users.email' => 10,
        ],
    ];

    public function scopeFilter(Builder $builder,$filters){

        $builder->when($filters['name'] ?? false,function ($builder,$value){
            $builder->where('users.name','LIKE', "%{$value}%");
        });
        $builder->when($filters['email'] ?? false,function ($builder,$value){
            $builder->where('users.email','LIKE', "%{$value}%");
        });
    }


    public function subscription(){
        return $this->hasOne(Subscription::class);
    }


    public function profile(){
        return $this->hasOne(UserProfile::class,'user_id' , 'id')
        ->withDefault();
    }


    public function stores(){

        return $this->belongsToMany(Store::class,'user_stores');
    }

    public function role()
    {
        return $this->belongsTo(RoleUser::class, 'role_id');
    }



    public function parent(){
        return $this->belongsTo(User::class, 'is_admin','id')
        ->withDefault([

        ]);
    }

    public function children(){
        return $this->hasMany(User::class,'is_admin','id');
    }



    public function cards(){
        return $this->hasMany(Card::class);
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
