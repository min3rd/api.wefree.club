<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    public $timestamps = false;

    public function animes(){
        return $this->belongsToMany(Anime::class);
    }

    public static function saveAll($models){
        $result = [];
        try {
            foreach ($models as $model){
                $author = Author::updateOrCreate($model);
                $result[] = $author;
            }
        }catch (Exception $exception){
            Log::error($exception);
        }
        return $result;
    }
    public static function saveAll_Ids($models){
        $result = [];
        try {
            foreach ($models as $model){
                $author = Author::updateOrCreate($model);
                $result[] = $author->id;
            }
        }catch (Exception $exception){
            Log::error($exception);
        }
        return $result;
    }

}
