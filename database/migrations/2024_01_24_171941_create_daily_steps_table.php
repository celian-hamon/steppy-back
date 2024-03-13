<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('daily_steps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stepCount');
            $table->timestamp('day');
            $table->uuid('userId');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');  
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_steps');
    }
}
