<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // 一括代入可能な属性を指定
    protected $fillable = [
        'user_id',
        'name',
        'brand',
        'description',
        'price',
        'condition',
        'status',
        'image', // 画像のパスを保存するカラム
    ];
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    
}
