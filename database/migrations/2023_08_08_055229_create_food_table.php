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
        Schema::create('food', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name');
            $table->string('description')->nullable();
            $table->dateTime('consumed_time')->default(now());
            $table->float('calorie');
            $table->integer('count')->default(1);
            $table->unsignedBigInteger("uid");
            $table->foreign('uid')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food');
    }
};
