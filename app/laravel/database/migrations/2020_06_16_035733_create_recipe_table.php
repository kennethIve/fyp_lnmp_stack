<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe', function (Blueprint $table) {
            //columns
            $table->id('recipe_id');
            $table->string('name')->nullable();
            $table->integer('star')->nullable();
            $table->float('duration')->nullable();
            $table->string('author')->nullable();
            $table->string('description')->nullable();
            

            //relationship
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe');
    }
}
