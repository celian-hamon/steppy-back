<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBadgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('name');
            $table->string('description');
            // isStreak is a boolean that indicates if the badge need a streak to be unlock or a step amount
            $table->boolean('isStreak');
            $table->integer('quantity');
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
        Schema::dropIfExists('badges');
    }
}
