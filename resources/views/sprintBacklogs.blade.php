@extends('template')

@section('title', 'Sprint Backlog')

@section('content')
    <div class="page-content-wrapper" id="page-content-wrapper">
        <h2>Sprint Backlog de {{$project_name}} </h2>
    </div>
    <div class="table-responsive" style="min-height: 550px;">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th width="120"> Bloqueada </th>
                <th width="120"> Nueva </th>
                <th width="120"> En curso </th>
                <th width="120"> En revision </th>
                <th width="120"> Finalizada </th>
            </tr>
            </thead>
            <tbody>

            @foreach($tasks as $task)
                <tr>
                    @for($i = -1; $i<4; $i++)
                        <th style="text-align: center">
                        @if($task->state != $i)
                                <a href="../task/changeState/{{$i}}/{{$task->id}}" style="cursor: pointer; text-decoration: none">
                                    <i class="icon-edit big" style="font-size: 50px; opacity: 0.1"></i>
                                </a>
                        @else
                                <?php
                                if($task->actor != null){
                                    $actor = $task->actor;
                                }else{
                                    $actor = "null";
                                }
                                if($task->note != null){
                                    $note = $task->note;
                                }else{
                                    $note = "null";
                                }
                                ?>
                                <div class="row-fluid hideInIE8 circleStats">
                                <div class="post span2" onTablet="span4" onDesktop="span2" style="width: 90%;">
                                    <a id='{{$task->redmine_id}}' class="left-clicked" target="_blank" style="text-decoration: none">
                                        <div id="click-{{$task->redmine_id}}" onclick="showModal({{$task->id}},'{{$actor}}','{{$note}}')"></div>
                                        <div class="circleStatsItemBox {{$task->getColorState()}}" style="margin-left: 10px; margin-right: 10px">
                                            <div class="header">#{{$task->redmine_id}}</div>
                                            <div class="circleStat">
                                                <p style="font-weight: normal">{{DB::table('projects')->where('id','=',$task->project_id)->first()->name}}</p>
                                                <p style="font-weight: normal">{{$task->description}}</p>
                                                <p style="font-weight: normal">Prioridad: {{$task->getPriority()}}</p>
                                                @if($task->ph != null)
                                                    <p style="font-weight: normal">Puntos de historia: {{$task->ph}}</p>
                                                @endif
                                                @if($task->note != null)
                                                    <p style="font-weight: normal">Nota: {{$task->note}}</p>
                                                @endif
                                            </div>
                                            <div class="footer">
                                                <span class="count">
                                                    @if($task->actor != null)
                                                        <p style="font-weight: normal">{{$task->actor}}</p>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endif
                        </th>
                    @endfor
                </tr>
            @endforeach
            <script>
                function showModal(id,actor,note){
                    $('#actor option[value="'+actor+'"]').prop('selected',true);
                    $('#id').val(id);
                    $('#note').val(note);
                    $('#modal').modal('toggle')
                }
            </script>
            </tbody>
        </table>
    </div>
    <div class="modal hide fade" id="modal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Editar tarea</h3>
        </div>
        <div class="modal-body">
            <form action="../task/updateInSprint" method="POST">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input id='id' type="hidden" name="id" value="">
                <div class="form-group col-md-12 col-xs-12">
                    <label required class="control-label">Asignar a</label>
                    <div>
                        <select id="actor" name="actor">
                            <option value="0"> No asignar</option>
                            @foreach($users as $user)
                                <option value="{{$user->username}}"> {{$user->username}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-12 col-xs-12">
                    <label class="control-label">Nota</label>
                    <input type="text" id="nota" name="note" class="form-control"/>
                </div>
                <div class="margin-top-10 col-xs-12">
                    <button type="submit" class="btn green pull-right"> Editar </button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
        </div>
    </div>
    @include('clickmenu')
@endsection