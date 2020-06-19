<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            //columns 
            $table->id('recipe_ingredients_id');
            $table->unsignedBigInteger('recipe_id');
            $table->bigInteger('sequence');
            $table->string('content')->nullable();

            //realtionship
            $table->foreign('recipe_id')->references('recipe_id')->on('recipe')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_ingredients');
    }
}
