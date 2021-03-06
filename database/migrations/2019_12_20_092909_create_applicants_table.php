<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('twitch_id')->unique();
            $table->string('avatar')->nullable();
            $table->string('username');
            $table->string('email');
            $table->string('discord')->nullable();
            $table->string('name')->nullable();
            $table->boolean('approved');
            $table->boolean('denied');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('invited');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}
