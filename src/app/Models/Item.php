<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable=[
        'user_id',
        'name',
        'path',
        'brand',
        'condition',
        'explanation',
        'price',
    ];

    public function scopeItemSearch($query,$name){
        if(!empty($name)){
            $query->where('name','like','%'.$name.'%');
        }
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }

    public function accesses(){
        return $this->hasMany(Access::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }
}
