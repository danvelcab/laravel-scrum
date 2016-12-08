<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTasksTable extends Migration {

	public function up()
	{
		Schema::create('tasks', function(Blueprint $table) {
			$table->increments('id');
			$table->string('redmine_id')->nullable();
			$table->string('ref')->nullable();
			$table->tinyInteger('type');
			$table->text('description');
			$table->smallInteger('state');
			$table->string('actor')->nullable();
			$table->tinyInteger('priority');
			$table->text('url')->nullable();
			$table->mediumInteger('ph')->nullable();
			$table->text('note')->nullable();
			$table->timestamps();
			$table->integer('project_id')->unsigned();
			$table->integer('sprint_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('tasks');
	}
}