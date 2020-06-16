<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->unsignedBigInteger('recipe_id');
            $table->bigInteger('sequence');
            $table->string('description')->nullable();

            //relationship
            $table->primary(array('recipe_id','sequence'));
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
        Schema::dropIfExists('steps');
    }
}
