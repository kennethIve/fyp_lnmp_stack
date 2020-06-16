<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_recipe', function (Request $request) {
    return json_encode(array("data"=>"get recipe api"));
});
Route::get('/details', 'API\RecipeApiController@details')->middleware("auth:api");
Route::get('/insertRecipe', 'API\RecipeApiController@insert')->middleware("auth:api");
    // group(['middleware' => 'auth:api'], function(){
    // Route::any('details', 'API\RecipeApiController@details');