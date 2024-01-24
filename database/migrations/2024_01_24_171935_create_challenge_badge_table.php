<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengeBadgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('challenge_badge', function (Blueprint $table) {
            $table->bigInteger('challengeId')->primary();
            $table->foreign('challengeId')->references('id')->on('challenges');
            $table->bigInteger('badgeId');
            $table->foreign('badgeId')->references('id')->on('badges');
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
        Schema::dropIfExists('challenge_badge');
    }
}
