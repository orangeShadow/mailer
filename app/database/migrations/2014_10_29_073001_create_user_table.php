<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateUserTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('users', function($table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('full_name')->nullable();
            $table->string('role')->nullable();
            $table->string('remember_token',100)->nullable(); //Обязательное поле, для защищенности Cookie
            $table->softDeletes();
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
        Schema::drop('users');
	}

}
