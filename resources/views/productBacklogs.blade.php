@extends('template')

@section('title', 'Product Backlog')

@section('content')
    <div class="page-content-wrapper" id="page-content-wrapper">
        <h2>Product Backlog de {{$project_name}} <a href="../task/create"><span class="halflings-icon plus-sign" aria-hidden="true"></span></a></h2>
    </div>

    <?php $i = 0?>
    @foreach($tasks as $task)
        <?php
            if($task->sprint_id != null){
                $sprint = $task->sprint_id;
            }else{
                $sprint = "null";
            }
            if($task->ph != null){
                $ph = $task->ph;
            }else{
                $ph = "null";
            }
            if($task->ref != null){
                $ref = $task->ref;
            }else{
                $ref = "null";
            }
            if($task->redmine_id != null){
                $redmine_id = $task->redmine_id;
            }else{
                $redmine_id = "null";
            }
        ?>
        @if($i%6 == 0)
            <div class="row-fluid hideInIE8 circleStats">
        @endif
        <div class="post span2" onTablet="span4" onDesktop="span2">
            <a id='{{$task->redmine_id}}' class="left-clicked" target="_blank" style="text-decoration: none">
                <div id="click-{{$task->redmine_id}}" onclick="showModal({{$task->id}},{{$sprint}},{{$ph}},'{{$ref}}',{{$redmine_id}})"></div>
                <div class="circleStatsItemBox {{$task->getColorState()}}">
                    <div class="header">{{$task->ref}} #{{$task->redmine_id}} - {{DB::table('projects')->where('id','=',$task->project_id)->first()->name}}</div>
                    <div class="circleStat">
                        <p>{{$task->description}}</p>
                        <p>Prioridad: {{$task->getPriority()}}</p>
                        <p>Estado: {{$task->getState()}}</p>
                        <p>Tipo: {{$task->getType()}}</p>
                        <p>Asignado a: {{$task->actor}}</p>
                        <p>Puntos de historia: {{$task->ph}}</p>
                    </div>
                    <div class="footer">
                        <span class="count">
                            <p>Sprint: {{$task->sprint_id}}</p>
                        </span>
                    </div>
                </div>
            </a>
        </div>
        @if($i%6 == 5 || $i == sizeof($tasks)-1)
            </div>
        @endif

                <?php $i++ ?>

    @endforeach

    <script>
        function showModal(id,sprint_id, ph, ref, redmine_id){
            $('#sprint option[value="'+sprint_id+'"]').prop('selected',true);
            $('#id').val(id);
            $('#redmine_id').val(redmine_id);
            $('#ref').val(ref);
            $('#ph').val(ph);
            $('#modal').modal('toggle')
        }
    </script>
        <div class="modal hide fade" id="modal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Editar tarea</h3>
            </div>
            <div class="modal-body">
                <form action="../task/updateInProduct" method="POST">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input id='id' type="hidden" name="id" value="">
                    <div class="form-group col-md-12 col-xs-12">
                        <label required class="control-label">Sprint</label>
                        <div>
                            <select id="sprint" name="sprint">
                                <option value="0"> No asignar a un sprint</option>
                                @foreach($sprints as $sprint)
                                    <option value="{{$sprint->id}}"> {{$sprint->id}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12 col-xs-12">
                        <label class="control-label">Redmine id</label>
                        <input type="text" id="redmine_id" name="redmine_id" class="form-control"/>
                    </div>
                    <div class="form-group col-md-12 col-xs-12">
                        <label class="control-label">Ref: </label>
                        <input type="text" id="ref" name="ref" class="form-control"/>
                    </div>
                    <div class="form-group col-md-12 col-xs-12">
                        <label class="control-label">Puntos de historia</label>
                        <input type="number" id="ph" min="0" step="1" name="ph" class="form-control"/>
                    </div>
                    <div class="margin-top-10 col-xs-12">
                        <button type="submit" class="btn green pull-right"> Editar </button>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
    @include('clickmenu')
@endsection