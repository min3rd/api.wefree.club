<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "short_name",
        "jp_name",
        "short_jp_name",
        "en_name",
        "short_en_name",
        "description",
        "short_description",
        "thumbnail",
        "images",
        "published_at",
        "flag"
    ];

    public function episodes(){
        return $this->hasMany(Episode::class);
    }

    public function authors(){
        return $this->belongsToMany(Author::class);
    }

    public function actors(){
        return $this->belongsToMany(Actor::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
