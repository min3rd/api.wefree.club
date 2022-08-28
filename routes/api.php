<?php

use App\Http\Controllers\AnimeController;
use App\Models\Anime;
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
        var_dump($request->all());
       $anime = Anime::updateOrCreate($request->all());
       return $anime;
    });
});
