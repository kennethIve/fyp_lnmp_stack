<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{
    //
    protected $table = "recipe_ingredients";

    protected $primaryKey = "recipe_ingredients_id";    
    public $timestamps = false;
}
