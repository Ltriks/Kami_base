<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 50);
            $table->string('password', 50);
            $table->string('mobile', 50);
            $table->string('email', 100);
            $table->string('name', 100);
            $table->string('avatar', 255);
            $table->tinyInteger('gender');
            $table->string('remember_token', 500);
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
        Schema::drop('user');
    }
}
