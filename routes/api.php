<?php

use App\Http\Controllers\AnimeController;
use App\Models\Anime;
use App\Models\Author;
use App\Models\Category;
use App\Models\Episode;
use App\Services\GraphService;
use App\Util\ParameterUtils;
use GuzzleHttp\Client;
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
        $authors = ParameterUtils::Exist($model, "authors", []);
        $episodes = ParameterUtils::Exist($model, "episodes", []);
        unset($model["authors"]);
        unset($model["episodes"]);
        /**
         * @var Anime $anime
         */
        $anime = Anime::updateOrCreate($model);
        if(count($authors) > 0){
            $ids = Author::saveAll_Ids($authors);
            $anime->authors()->detach($ids);
            $anime->authors()->attach($ids);
        }
        if(count($episodes) > 0){
            $episodes = Episode::saveAll($episodes);
            $anime->episodes()->saveMany($episodes);
        }
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

Route::prefix("categories")->group(function (){
    Route::get("/", function (Request $request){
        Category::all();
    });
});

Route::prefix("graph")->group(function (){
    Route::get("/test/{username}", function (Request $request){
        $username = $request->input("username");
        $user = GraphService::getUserInfo($username);
        return $user;
    });
});
