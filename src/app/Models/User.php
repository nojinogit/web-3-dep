<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'postcode',
        'address',
        'building',
        'path',
        'stripe_id',
        'point',
        'bank',
        'bank_branch',
        'bank_type',
        'bank_number'
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
        'password' => 'hashed',
    ];

    public function items(){
        return $this->hasMany(Item::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    public function accesses(){
        return $this->hasMany(Access::class);
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }

    public function proceeds(){
        return $this->hasMany(Proceed::class);
    }

    public function scopeNameSearch($query,$name){
        if(!empty($name)){
            $query->where('name','like','%'.$name.'%');
        }
    }

    public function scopeEmailSearch($query,$email){
        if(!empty($email)){
            $query->where('email',$email);
        }
    }

    public function scopeRoleSearch($query,$role){
        if(!empty($role)){
            $query->where('role',$role);
        }
    }
}
