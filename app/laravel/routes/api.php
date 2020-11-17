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

Route::any('/details','API\RecipeApiController@details')->middleware("restfulapi");
//testing route
Route::any('/test', 'API\RecipeApiController@test');
//name search
Route::get('/getRecipesByName', 'API\RecipeApiController@searchRecipeBykeywords');
//for list page the use
Route::get('/getRecipes', 'API\RecipeApiController@getAllRecipe');

//ingredient search
Route::post('/ingredientSearch', 'API\RecipeApiController@ingredientSearch')->middleware("restfulapi");
//detail search for search page
Route::post('/search', 'API\RecipeApiController@search')->middleware("restfulapi");
//for crawler to get
Route::post('/insertFromBbcFood', 'API\RecipeApiController@insertFromBbcFood')->middleware("restfulapi");

//for update old image path api // disable after use
Route::get('/updateImage', 'API\RecipeApiController@updateImage');