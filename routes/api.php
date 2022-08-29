<?php

use App\Http\Controllers\AnimeController;
use App\Models\Anime;
use App\Models\Author;
use App\Util\ParameterUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix("animes")->group(function (){
    Route::get("/", function (Request $request){
        $page = $request->query("page");
        $size = $request->query("size");
        return [
            "page" => $page,
            "size" => $size,
        ];
    });
    Route::post("/", function (Request $request){
        $model = $request->all();
        $id = ParameterUtils::Exist($model, "id");
        if(!$id){
            $anime = Anime::updateOrCreate($request->all());
        }else{
            $anime = Anime::findOrFail($id);
            if(!$anime){
                return false;
            }
            $anime->fill($model);
            $anime->save();
        }
        if(!ParameterUtils::Exist($model, "authors")){
            return $anime;
        }
        $authors = $model["authors"];
        var_dump($authors);
        $authors = Author::saveAll($authors);
        $anime->authors->attach($authors);
        return $anime;
    });
    Route::get("/search", function(Request $request){
       $name = $request->query("name", "");
       $published_at = $request->query("publish_at", date("Y", time()));
       $categories = $request->query("categories", "");
    });
    Route::get("/episodes", function (Request $request){

    });
});
