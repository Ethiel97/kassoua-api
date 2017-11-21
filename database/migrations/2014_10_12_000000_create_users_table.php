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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country');
            $table->string('enterprise');
            $table->string('gender')->nullable();
            $table->string('lname');
            $table->string('fname');
            $table->string('photo')->nullable();
            $table->string('job')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('email');
            $table->text('password');
            $table->unsignedInteger('enterprise_id')->nullable();
            $table->foreign('enterprise_id')->references('id')->on('enterprises');
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
        Schema::dropIfExists('users');
    }
}
