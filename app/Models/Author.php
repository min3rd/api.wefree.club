<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    public function animes(){
        return $this->belongsToMany(Anime::class);
    }

    public static function saveAll($models){
        $authors = [];
        foreach ($models as $model){
             $author = Author::findOrFail($model["id"]);
             if(!$author){
                 $author = Author::factory()->create($model);
                 if(!$author){
                     continue;
                 }
             }else{
                 $author->fill($model);
                 $author->save();
             }
            $authors[] = $author;
        }
        return $authors;
    }
}
