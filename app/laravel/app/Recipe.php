<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    //
    protected $table = "recipe";

    protected $primaryKey = "recipe_id";
    public $timestamps = false;

    public function steps()
    {
        return $this->hasMany("App\Steps","recipe_id","recipe_id");
    }

    public function ingredients()
    {
        return $this->hasMany("App\Ingredients","recipe_id","recipe_id");
    }
}
