<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {

	protected $table = 'projects';
	public $timestamps = true;

	public function tasks()
	{
		return $this->hasMany('Task');
	}

    public static function getNameByProjectId($project_id){
        if($project_id != 0){
            $project_name  = Project::find($project_id)->name;
        }else{
            $project_name  = 'Todos los proyectos';
        }
        return $project_name;
    }

}