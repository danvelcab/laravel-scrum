<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSprintsTable extends Migration {

	public function up()
	{
		Schema::create('sprints', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->date('start_date');
			$table->date('end_date');
		});
	}

	public function down()
	{
		Schema::drop('sprints');
	}
}