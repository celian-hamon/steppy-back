<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyChallengeStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('daily_challenge_steps', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('stepCount');
            $table->timestamp('day');
            $table->bigInteger('challengeId');
            $table->foreign('challengeId')->references('id')->on('challenges')->onDelete('cascade');
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
        Schema::dropIfExists('daily_challenge_steps');
    }
}
