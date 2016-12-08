<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Mail;

class Change extends Model {

	protected $table = 'changes';
	public $timestamps = true;

	public function actor()
	{
		return $this->belongsTo('Actor');
	}

	public function task()
	{
		return $this->belongsTo('Task');
	}

	public static function changeCreateTask($input, $taskId){
	    $actor = Auth::user();
        $actorId = $actor->id;
        $task = Task::find($taskId);
        $change = new Change();
        $change->actor_id = $actorId;
        $change->task_id = $taskId;
        $type = 'tarea';
        if($task->type == 1){
            $type = 'incidencia';
        }
        $change->description =
            $task->created_at.' - '.
            $actor->username.' ha añadido una nueva '.$type.' al proyecto '.
            $input['project'].'. Descripcion: '.$input['description'];
        $change->save();

        Mail::to('danvelcab@gmail.com')->send(new ChangeMail($change,
            '['.$task->getPriority().']'.' - Creacion '.$type));

    }
    public static function changeInProduct($input,$taskId){
        $actor = Auth::user();
        $actorId = $actor->id;
        $task = Task::find($taskId);
        $change = new Change();
        $change->actor_id = $actorId;
        $change->task_id = $taskId;
        $type = 'tarea';
        if($task->type == 1){
            $type = 'incidencia';
        }
        $change->description =
            Carbon::now().' - '.
            $actor->username.' ha modificado la '.$type.' "'.$task->description.'" '.
            '. Sprint: '.$input['sprint'].', PH: '.$task->ph;
        $change->save();
        Mail::to('danvelcab@gmail.com')->send(new ChangeMail($change,
            '['.$task->getPriority().']'.' - Cambio en una '.$type));
    }
    public static function changeInSprint($input, $taskId){
        $actor = Auth::user();
        $actorId = $actor->id;
        $task = Task::find($taskId);
        $change = new Change();
        $change->actor_id = $actorId;
        $change->task_id = $taskId;
        $type = 'tarea';
        if($task->type == 1){
            $type = 'incidencia';
        }
        if($task->actor != null){
            $change->description =
                Carbon::now().' - '.
                $actor->username.' ha asignado la '.$type.' "'.$task->description.'" '.
                'a '.$input['actor'];
        }else{
            $change->description =
                Carbon::now().' - '.
                $actor->username.' ha eliminado la asignacion de la '.$type.' "'.$task->description.'"';
        }
        $change->save();
        Mail::to('danvelcab@gmail.com')->send(new ChangeMail($change,
            '['.$task->getPriority().']'.' - Cambio en una '.$type));
    }
    public static function changeState($previousState, $state, $taskId){
        $actor = Auth::user();
        $actorId = $actor->id;
        $task = Task::find($taskId);
        $change = new Change();
        $change->actor_id = $actorId;
        $change->task_id = $taskId;
        $type = 'tarea';
        if($task->type == 1){
            $type = 'incidencia';
        }
        $change->description =
            Carbon::now().' - '.
            $actor->username.' ha cambiado la '.$type.' "'.$task->description.'" '.
            'de '.Task::getStateById($previousState). ' a ' .Task::getStateById($state);
        $change->save();
        Mail::to('danvelcab@gmail.com')->send(new ChangeMail($change,
            '['.$task->getPriority().']'.' - Cambio de estado en una '.$type));
    }

}