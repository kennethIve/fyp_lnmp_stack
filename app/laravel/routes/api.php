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

Route::any('/details',       'API\RecipeApiController@details')->middleware("restfulapi");

Route::get('/getRecipes', 'API\RecipeApiController@getAllRecipe');
Route::post('/insertFromBbcFood', 'API\RecipeApiController@insertFromBbcFood')->middleware("restfulapi");
    // group(['middleware' => 'auth:api'], function(){
    // Route::any('details', 'API\RecipeApiController@details');