<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'name',
        'path',
        'brand',
        'condition',
        'explanation',
        'price',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function categories(){
        return $this->hasMany(Category::class);
    }
}