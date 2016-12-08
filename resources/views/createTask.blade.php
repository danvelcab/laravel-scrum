@extends('template')

@section('title', 'Page Title')

@section('content')
	<form action="store" method="POST">
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		<h2>Nueva tarea</h2>
		<div class="form-group col-md-12 col-xs-12">
			<label class="control-label">Redmine id</label>
			<input type="text" id="redmine_id" name="redmine_id" class="form-control"/>
		</div>
		<div class="form-group col-md-12 col-xs-12">
			<label required class="control-label">Proyecto</label>
			<div>
				<select name="project">
					@foreach($projects2 as $project)
						<option value="{{$project->id}}"> {{$project->name}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="form-group col-md-12 col-xs-12">
			<label class="control-label">Ref: </label>
			<input type="text" id="ref" name="ref" class="form-control"/>
		</div>
		<div class="form-group col-md-12 col-xs-12">
			<label required class="control-label">Tipo</label>
			<div>
				<select name="type">
					<option value="0"> Tarea </option>
					<option value="1"> Incidencia </option>
				</select>
			</div>
		</div>
		<div class="form-group col-md-12 col-xs-12">
			<label class="control-label">Descripcion (5 o 6 palabras): </label>
			<input required type="text" id="descripcion" name="description" class="form-control"/>
		</div>
		<div class="form-group col-md-12 col-xs-12">
			<label required class="control-label">Prioridad</label>
			<div>
				<select name="priority">
					<option value="0"> Baja </option>
					<option value="1"> Media </option>
					<option value="2"> Alta </option>
					<option value="3"> Inmediata </option>
				</select>
			</div>
		</div>

		<div class="margin-top-10 col-xs-12">
			<button type="submit" class="btn green pull-right"> Añadir</button>
		</div>
	</form>
@endsection
