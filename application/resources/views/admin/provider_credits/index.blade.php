@extends('adminlte::page')

@section('title', $title)

@include('flash::message')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>{{ $title }}</h2>
		</div>
		<div class="panel-body">
			<a class="btn btn-success" href="{{ route('provider-credits.create') }}"><i class="fas fa-plus"></i> Nuevo</a>
			<br />
			<br />
			<table class="table table-bordered table-striped data-table">
				<thead>
					<th>ID</th>
					<th>Conductor</th>
					<th>Credito</th>
					<th>Fecha/Hora Operación</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($data as $d)
						<tr>
							<td>{{ $d->id }}</td>
							<td>{{ $d->provider }}</td>
							<td>{{ $d->credit }}</td>
							<td>{{ date('d-m-Y H:m:s',strtotime($d->created_at)) }}</td>
							<td></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop

@section('js')
	<script type="text/javascript">
		$(document).ready(function(){
			$("table.data-table").DataTable();
			$('#flash-overlay-modal').modal();
		});
	</script>
@stop