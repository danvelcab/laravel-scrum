<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('changes', function(Blueprint $table) {
			$table->foreign('actor_id')->references('id')->on('actors')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('changes', function(Blueprint $table) {
			$table->foreign('change_id')->references('id')->on('tasks')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('tasks', function(Blueprint $table) {
			$table->foreign('project_id')->references('id')->on('projects')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('tasks', function(Blueprint $table) {
			$table->foreign('sprint_id')->references('id')->on('sprints')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('changes', function(Blueprint $table) {
			$table->dropForeign('changes_actor_id_foreign');
		});
		Schema::table('changes', function(Blueprint $table) {
			$table->dropForeign('changes_change_id_foreign');
		});
		Schema::table('tasks', function(Blueprint $table) {
			$table->dropForeign('tasks_project_id_foreign');
		});
		Schema::table('tasks', function(Blueprint $table) {
			$table->dropForeign('tasks_sprint_id_foreign');
		});
	}
}