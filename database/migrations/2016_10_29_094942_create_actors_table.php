<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActorsTable extends Migration {

	public function up()
	{
		Schema::create('actors', function(Blueprint $table) {
			$table->increments('id');
			$table->string('username');
			$table->string('password');
			$table->string('email');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('actors');
	}
}