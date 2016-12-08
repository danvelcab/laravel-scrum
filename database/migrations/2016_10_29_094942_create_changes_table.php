<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChangesTable extends Migration {

	public function up()
	{
		Schema::create('changes', function(Blueprint $table) {
			$table->increments('id');
			$table->text('description');
			$table->timestamps();
			$table->integer('actor_id')->unsigned();
			$table->integer('change_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('changes');
	}
}