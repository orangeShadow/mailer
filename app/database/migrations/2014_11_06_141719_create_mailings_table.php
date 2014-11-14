<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('mailings', function($table) {
            $table->increments('id');
            $table->string('title');
            $table->text('groups');
            $table->integer('template_id') ;
            $table->text('content');
            $table->boolean('repeat')->nullable();
            $table->dateTime('startdt');
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
        Schema::drop('mailings');
	}

}
