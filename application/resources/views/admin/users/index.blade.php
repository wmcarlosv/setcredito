@extends('adminlte::page')

@section('title', $title)

@include('flash::message')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>{{ $title }}</h2>
		</div>
		<div class="panel-body">
			<a class="btn btn-success" href="{{ route('users.create') }}"><i class="fas fa-plus"></i> Nuevo</a>
			<br />
			<br />
			<table class="table table-bordered table-striped data-table">
				<thead>
					<th>ID</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Correo</th>
					<th>Telefono</th>
					<th>Rol</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($data as $d)
						<tr>
							<td>{{ $d->id }}</td>
							<td>{{ $d->name }}</td>
							<td>{{ $d->last_name }}</td>
							<td>{{ $d->email }}</td>
							<td>{{ $d->phone }}</td>
							<td>
								@switch($d->role)
									@case('administrator')
										<label class="label label-success">Administrador</label>
									@break
									@case('sales')
										<label class="label label-info">Vendedor</label>
									@break
									@case('sales_point')
										<label class="label label-warning">Puntos de Venta</label>
									@break
								@endswitch

							</td>
							<td>
								<a class="btn btn-info" href="{{ route('users.edit',[$d->id]) }}"><i class="fas fa-edit"></i> Editar</a>
								{!! Form::open(['route' => ['users.destroy',$d->id], 'method' => 'DELETE', 'style' => 'display:inline']) !!}
									@if($d->isactive == 'active')
										<button class="btn btn-danger change_status"><i class="fas fa-times"></i> Desactivar</button>
									@else
										<button class="btn btn-success change_status"><i class="fas fa-check"></i> Activar</button>
									@endif
								{!! Form::close() !!}
							</td>
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

			$("button.change_status").click(function(){
				if(!confirm("Estas seguro de Activar o Desactivar el Registo?")){
					return false;
				}
			});
		});
	</script>
@stop