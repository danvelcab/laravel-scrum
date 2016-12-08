<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DB;

class Task extends Model {

    //Estados -1 - bloqueada, 0 - nueva, 1 - en curso, 2 - resuelta, 3 - finalizada
    //Prioridad 0 - baja, 1 - normal, 2 - alta, 3 - inmediata
	protected $table = 'tasks';
	public $timestamps = true;

	public function sprint()
	{
		return $this->belongsTo('Sprint');
	}

	public function project()
	{
		return $this->belongsTo('Project');
	}

	public function changes()
	{
		return $this->hasMany('Change');
	}

	public function getState(){
	    $state = $this->state;
        if($state == 0){
            return "Nueva";
        }elseif ($state == 1){
            return "En curso";
        }elseif ($state == 2){
            return "En revision";
        }elseif ($state == 3){
            return "Finalizada";
        }elseif ($state == -1){
            return "Bloqueada";
        }
    }
    public static function getStateById($state){
        if($state == 0){
            return "Nueva";
        }elseif ($state == 1){
            return "En curso";
        }elseif ($state == 2){
            return "En revision";
        }elseif ($state == 3){
            return "Finalizada";
        }elseif ($state == -1){
            return "Bloqueada";
        }
    }
    public function getColorState(){
        $state = $this->state;
        if($state == 0){
            return "yellow";
        }elseif ($state == 1){
            return "pink";
        }elseif ($state == 2){
            return "green";
        }elseif ($state == 3){
            return "blue";
        }elseif ($state == -1){
            return "red";
        }
    }

    public function getPriority(){
        $priority = $this->priority;
        if($priority == 0){
            return "Baja";
        }elseif ($priority == 1){
            return "Normal";
        }elseif ($priority == 2){
            return "Alta";
        }elseif ($priority == 3){
            return "Inmediata";
        }
    }
    public function getType(){
        $type = $this->type;
        if($type == 0){
            return "Tarea";
        }elseif ($type == 1){
            return "Incidencia";
        }
    }
    public static function store($input){
        $respuesta = array();
        $reglas = array(
            'project' => array('required'),
            'type' => array('required'),
            'description' => array('required'),
            'priority' => array('required'),
        );
        $validator = Validator::make($input, $reglas);

        if ($validator->fails()) {
            $respuesta['mensaje'] = $validator;
            $respuesta['error'] = true;
        } else {
            $task = new Task();
            $task->redmine_id = $input['redmine_id'];
            $task->ref = $input['ref'];
            $task->type = $input['type'];
            $task->description = $input['description'];
            $task->state = 0;
            $task->priority = $input['priority'];
            $task->project_id = $input['project'];
            $task->save();
            Change::changeCreateTask($input, $task->id);

            $respuesta['mensaje'] = 'Tarea creada';
            $respuesta['error'] = false;
            $respuesta['data'] = $task;
        }
        return $respuesta;
    }
    public static function updateInProduct($input){
        $respuesta = array();
        $reglas = array(
            'id' => array('required'),
            'sprint' => array('required'),
        );
        $validator = Validator::make($input, $reglas);

        if ($validator->fails()) {
            $respuesta['mensaje'] = $validator;
            $respuesta['error'] = true;
        } else {
            $task = Task::find($input['id']);
            if($input['sprint'] != 0){
                $task->sprint_id = $input['sprint'];
            }
            $task->redmine_id = $input['redmine_id'];
            $task->ref = $input['ref'];
            if($input['ph'] != ''){
                $task->ph = $input['ph'];
            }
            $task->save();
            Change::changeInProduct($input, $task->id);

            $respuesta['mensaje'] = 'Tarea actualizada';
            $respuesta['error'] = false;
            $respuesta['data'] = $task;
        }
        return $respuesta;
    }
    public static function updateInSprint($input){
        $respuesta = array();
        $reglas = array(
            'id' => array('required'),
        );
        $validator = Validator::make($input, $reglas);

        if ($validator->fails()) {
            $respuesta['mensaje'] = $validator;
            $respuesta['error'] = true;
        } else {
            $task = Task::find($input['id']);
            if($input['actor'] != "0"){
                $task->actor = $input['actor'];
            }else{
                $task->actor = null;
            }
            $task->note = $input['note'];
            $task->save();
            Change::changeInSprint($input, $task->id);

            $respuesta['mensaje'] = 'Tarea actualizada';
            $respuesta['error'] = false;
            $respuesta['data'] = $task;
        }
        return $respuesta;
    }
    public static function getTasksByProjectId($project_id){
        if($project_id != 0){
            $tasks = Task::where('project_id','=', $project_id)
                ->where('enabled','=',1)
                ->orderBy('priority','desc')
                ->get();
        }else{
            $tasks = Task::where('enabled','=',1)
                ->orderBy('priority','desc')
                ->get();
        }
        return $tasks;
    }
    public static function getTasksByProjectIdAndSprintId($project_id, $sprint_id){
        if($project_id != 0){
            $tasks = Task::where('project_id','=', $project_id)
                ->where('sprint_id','=',$sprint_id)
                ->where('enabled','=',1)
                ->orderBy('priority','desc')
                ->get();
        }else{
            $tasks = Task::where('sprint_id','=',$sprint_id)
                ->where('enabled','=',1)
                ->orderBy('priority','desc')
                ->get();
        }
        return $tasks;
    }
    public static function getMyTasksByProjectIdAndSprintId($project_id, $sprint_id){
        $user = Auth::user();
        if($project_id != 0){
            $tasks = Task::where('project_id','=', $project_id)
                ->where('sprint_id','=',$sprint_id)
                ->where('actor', '=', $user->username)
                ->where('enabled','=',1)
                ->orderBy('priority','desc')
                ->get();
        }else{
            $tasks = Task::where('sprint_id','=',$sprint_id)
                ->where('actor', '=', $user->username)
                ->where('enabled','=',1)
                ->orderBy('priority','desc')
                ->get();
        }
        return $tasks;
    }
    public static function changeState($state, $task_id){
        $task = Task::find($task_id);
        $respuesta = array();
        if($task == null){
            $respuesta['mensaje'] = 'La tarea seleccionada no existe';
            $respuesta['error'] = true;
            $respuesta['data'] = null;

            return $respuesta;
        }
        if($state != -1 && $state != 0 && $state != 1 && $state != 2 && $state != 3){
            $respuesta['mensaje'] = 'El estado seleccionado no existe';
            $respuesta['error'] = true;
            $respuesta['data'] = null;

            return $respuesta;
        }
        if($state == 3){
            $task->end_date = Carbon::now();
        }else{
            $task->end_date = null;
        }
        $previousState = $task->state;
        $task->state = $state;
        $task->save();
        if($state != $previousState){
            Change::changeState($previousState, $state, $task->id);
        }
        $respuesta['mensaje'] = 'El estado de la tarea ha sido cambiado';
        $respuesta['error'] = false;
        $respuesta['data'] = $task;

        return $respuesta;
    }

    public static function getTotalPHByProjectIdAndSprintId($project_id, $sprint_id, $days){
        if($project_id != 0){
            $ph = Task::where('project_id','=', $project_id)
                ->where('sprint_id','=',$sprint_id)
                ->where('enabled','=',1)
                ->select(DB::raw('SUM(ph) as ph'))
                ->get();
        }else{
            $ph = Task::where('sprint_id','=',$sprint_id)
                ->where('enabled','=',1)
                ->select(DB::raw('SUM(ph) as ph'))
                ->get();
        }
        $result = array();
        $ph = intval($ph[0]->ph);
        $phPerDay = $ph/($days - 1);
        for ($i=0; $i<$days-1; $i++){
            array_push($result, intval($ph - $i*$phPerDay));
        }
        array_push($result, 0);
        return $result;
    }
    public static function getCurrentPHByProjectIdAndSprintId($project_id, $sprint_id, $labels,$totalPH){
        $total = $totalPH[0];
        $result = array();
        foreach ($labels as $label){
            if($project_id != 0){
                $ph = Task::where('project_id','=', $project_id)
                    ->where('sprint_id','=',$sprint_id)
                    ->where('enabled','=',1)
                    ->where('end_date','<',$labels." 00:00:00")
                    ->select(DB::raw('SUM(ph) as ph'))
                    ->get();
            }else{
                $ph = Task::where('sprint_id','=',$sprint_id)
                    ->where('end_date','<',$label." 00:00:00")
                    ->where('enabled','=',1)
                    ->select(DB::raw('SUM(ph) as ph'))
                    ->get();
            }

            $ph = $ph[0]->ph;
            if($ph == null){
                $ph = $total;
            }else{
                $ph = $total - intval($ph);
            }
            if(Carbon::now()->subDay() > Carbon::parse($label)){
                array_push($result, $ph);
            }
        }
        return $result;
    }
}