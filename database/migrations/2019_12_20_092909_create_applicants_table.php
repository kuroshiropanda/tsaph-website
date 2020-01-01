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
            $table->string('name')->nullable();
            $table->boolean('approved');
            $table->boolean('denied');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('invited');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('twitch_id')->references('applicant_id')->on('applications')->onDelete('cascade');
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
