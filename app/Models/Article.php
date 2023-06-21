<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    //? Relacion de uno a muchos inversa (article-user)
    public function user(){
        return $this->belongsTo(User::class);
    }

    //? Relacion de uno a muchos (articles-comments)
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    //? Relacion de uno a muchos inversa (category-article)
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
