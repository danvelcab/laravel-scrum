<?php 

namespace App\Http\Controllers;

use App\Project;
use App\Sprint;
use App\User;
use App\Task;
use Illuminate\Support\Facades\Redirect;
use DB;

class TaskController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
    public function productBacklogs($project_id)
    {
        $tasks = Task::getTasksByProjectId($project_id);
        $project_name = Project::getNameByProjectId($project_id);
        $sprints = Sprint::all();
        $projects = Project::all();
        return view('productBacklogs', ['projects' => $projects,
            'project_name' => $project_name,
            'tasks' => $tasks,
            'sprints' => $sprints]);
    }

    public function sprintBacklogs($project_id)
    {
        $sprint = Sprint::orderBy('id','desc')->first();
        $tasks = Task::getTasksByProjectIdAndSprintId($project_id, $sprint->id);
        $project_name = Project::getNameByProjectId($project_id);
        $projects = Project::all();
        $users = User::all();
        return view('sprintBacklogs', ['projects' => $projects, 'tasks' => $tasks, 'project_name' => $project_name,
        'users' => $users]);
    }

    public function mySprintBacklog($project_id)
    {
        $sprint = Sprint::orderBy('id','desc')->first();
        $tasks = Task::getMyTasksByProjectIdAndSprintId($project_id, $sprint->id);
        $project_name = Project::getNameByProjectId($project_id);
        $projects = Project::all();
        $users = User::all();
        return view('sprintBacklogs', ['projects' => $projects, 'tasks' => $tasks, 'project_name' => $project_name,
            'users' => $users]);
    }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
      $projects = Project::all();
      return view('createTask', ['projects2' => $projects]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
    public function store()
    {

        try{
            $respuesta = Task::store($_REQUEST);
            if ($respuesta['error'] == true) {
                if(!is_string($respuesta['mensaje'])){
                    return Redirect::back()->withErrors($respuesta['mensaje'])->withInput();
                }else{
                    return Redirect::back()->with('mensaje', $respuesta['mensaje'])->with('error', true);
                }
            } else {
                return Redirect::back()->with('mensaje', $respuesta['mensaje']);
            }
        }catch(ErrorException $e){
            return Redirect::back()->with('mensaje', $e->getMessage())->with('error', true);
        }
    }
    public function updateInProduct()
    {
        try{
            $respuesta = Task::updateInProduct($_REQUEST);
            if ($respuesta['error'] == true) {
                if(!is_string($respuesta['mensaje'])){
                    return Redirect::back()->withErrors($respuesta['mensaje'])->withInput();
                }else{
                    return Redirect::back()->with('mensaje', $respuesta['mensaje'])->with('error', true);
                }
            } else {
                return Redirect::back()->with('mensaje', $respuesta['mensaje']);
            }
        }catch(ErrorException $e){
            return Redirect::back()->with('mensaje', $e->getMessage())->with('error', true);
        }
    }
    public function updateInSprint()
    {
        try{
            $respuesta = Task::updateInSprint($_REQUEST);
            if ($respuesta['error'] == true) {
                if(!is_string($respuesta['mensaje'])){
                    return Redirect::back()->withErrors($respuesta['mensaje'])->withInput();
                }else{
                    return Redirect::back()->with('mensaje', $respuesta['mensaje'])->with('error', true);
                }
            } else {
                return Redirect::back()->with('mensaje', $respuesta['mensaje']);
            }
        }catch(ErrorException $e){
            return Redirect::back()->with('mensaje', $e->getMessage())->with('error', true);
        }
    }

    public function changeState($state, $task_id){
        try{
            $respuesta = Task::changeState($state, $task_id);
            if ($respuesta['error'] == true) {
                if(!is_string($respuesta['mensaje'])){
                    return Redirect::back()->withErrors($respuesta['mensaje'])->withInput();
                }else{
                    return Redirect::back()->with('mensaje', $respuesta['mensaje'])->with('error', true);
                }
            } else {
                return Redirect::back()->with('mensaje', $respuesta['mensaje']);
            }
        }catch(ErrorException $e){
            return Redirect::back()->with('mensaje', $e->getMessage())->with('error', true);
        }
    }

    public function burndown($project_id){
        $sprint = Sprint::orderBy('id','desc')->first();
        $days = Sprint::getDays($sprint);
        $labels = Sprint::getDayLabels($sprint, $days);
        $days = sizeof($labels);
        $totalPH = Task::getTotalPHByProjectIdAndSprintId($project_id, $sprint->id, $days);
        $project_name = Project::getNameByProjectId($project_id);
        $currentPH = Task::getCurrentPHByProjectIdAndSprintId($project_id, $sprint->id, $labels, $totalPH);
        return view('burnDown', ['sprint' => $sprint, 'days' => $days, 'totalPH' => $totalPH,
        'project_name' => $project_name, 'labels' => $labels, 'currentPH' => $currentPH]);

    }

    public function compareRedmine(){
        $tasks = Task::all();
        foreach ($tasks as $task){
            $redmine_issue = DB::connection('mysql_redmine')
                ->table('issues')
                ->where('id','=',$task->redmine_id)
                ->first();
            if($redmine_issue != null){
                // 1 en nueva, 2 en curso, 3 resuelta, 5 cerrada
                if($redmine_issue->status_id == 1){
                    $task->state = 0;
                    $task->end_date = null;
                }elseif ($redmine_issue->status_id == 2){
                    $task->state = 1;
                    $task->end_date = null;
                }elseif ($redmine_issue->status_id == 3){
                    $task->state = 2;
                    $task->end_date = null;
                }elseif ($redmine_issue->status_id == 5){
                    $task->state = 3;
                    $task->end_date = Carbon::now();
                }
                $task->save();
            }
        }
    }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    
  }
  
}

?>