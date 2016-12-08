
<div id="sidebar-left" class="span2">
    <div class="nav-collapse sidebar-nav">
        <ul class="nav nav-tabs nav-stacked main-menu">
            @if(isset($projects))
                <li @if(isset($project_name) && $project_name == 'Todos los proyectos') class="active" @endif>
                    <a href="0"><span class="hidden-tablet">Todos los proyectos</span></a>
                </li>
                @foreach($projects as $project)
                    <li @if(isset($project_name) && $project_name == $project->name) class="active" @endif >
                        <a href="{{$project->id}}"><span class="hidden-tablet"> {{$project->name}}</span></a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
