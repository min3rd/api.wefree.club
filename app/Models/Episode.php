<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public static function saveAll( $models){
        $result = [];
        if(!is_array($models)){
            return $result;
        }
        try {
            foreach ($models as $model){
                $episode = Episode::updateOrCreate($model);
                $result[] = $episode;
            }
        }catch (Exception $exception){
            Log::error($exception);
        }
        return $result;
    }

    public static function saveAll_Ids( $models){
        $result = [];
        if(!is_array($models)){
            return $result;
        }
        try {
            foreach ($models as $model){
                $episode = Episode::updateOrCreate($model);
                $result[] = $episode->id;
            }
        }catch (Exception $exception){
            Log::error($exception);
        }
        return $result;
    }
}
