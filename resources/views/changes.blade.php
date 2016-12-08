@extends('template')

@section('title', 'Page Title')

@section('content')
	<div class="box black span4" onTablet="span6" onDesktop="span4">
		<div class="box-header">
			<h2><i class="halflings-icon white user"></i><span class="break"></span>Ultimos cambios</h2>
		</div>
		<div class="box-content">
			<ul class="dashboard-list metro">
				<?php $colors = ['green', 'yellow', 'red', 'blue']; $i = 0;?>

				@foreach($changes as $change)
					<li class="{{$colors[$i%4]}}">
						<p style="margin-left: 10px; margin-right: 10px">{{$change->description}}</p>
					</li>
					<?php $i++; ?>
				@endforeach
			</ul>
		</div>
	</div>
@endsection
