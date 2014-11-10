<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('templates', function($table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('header')->nullable();
            $table->text('footer')->nullable();
            $table->text('css')->nullable();
            $table->text('meta')->nullable();
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
        Schema::drop('templates');
	}

}
