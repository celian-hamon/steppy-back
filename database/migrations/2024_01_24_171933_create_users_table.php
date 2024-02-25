<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('users', function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->bigInteger('avatarId');
            $table->foreign('avatarId')->references('id')->on('avatar');
            $table->bigInteger('age');
            $table->string('sexe');
            $table->bigInteger('jobId');
            $table->foreign('jobId')->references('id')->on('jobs');
            $table->boolean('shareData');
            $table->string('code');
            $table->timestamp('lastLogin')->nullable();
            $table->boolean('isAdmin');
            $table->string('password')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}