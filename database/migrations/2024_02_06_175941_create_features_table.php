<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->float('bmi');
            $table->float('weight');
            $table->float('height');
            $table->string('gender');
            $table->float('pressure');
            $table->float('sugar');
            $table->integer('age');
            $table->unsignedBigInteger("uid")->unique();
            $table->foreign('uid')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('features');
    }
};
