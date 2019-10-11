@extends('adminlte::page')

@section('title', $title)

@include('flash::message')

@section('content')
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>{{ $title }}</h2>
		</div>
		<div class="panel-body">
			<a class="btn btn-success" href="{{ route('sales.create') }}"><i class="fas fa-plus"></i> Nuevo</a>
			<br />
			<br />
			<table class="table table-bordered table-striped data-table">
				<thead>
					<th>ID</th>
					<th>De</th>
					<th>Para</th>
					<th>Credito Asignado</th>
					<th>Con Variacion</th>
					<th>Tipo de Variacion</th>
					<th>Variacion</th>
					<th>Fecha/Hora Operación</th>
					<th></th>
				</thead>
				<tbody>
					@foreach($data as $d)
						<tr>
							<td>{{ $d->id }}</td>
							<td>{{ $d->userf->name.' '.$d->userf->last_name }} ({{ $d->userf->role }})</td>
							<td>{{ $d->usert->name.' '.$d->usert->last_name }} ({{ $d->usert->role }})</td>
							<td>{{ $d->credits }}</td>
							<td>
								@if($d->is_variation)
									Si
								@else
									No
								@endif
							</td>
							<td>
								@if(!empty($d->variation_type))
									@if($d->variation_type == 'increment')
										Incremento
									@else
										Descuento
									@endif
								@else
									-
								@endif
							</td>
							<td>
								@if(!empty($d->variation))
									{{ $d->variation }}%
								@else
									-
								@endif
							</td>
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

			$("button.change_status").click(function(){
				if(!confirm("Estas seguro de Activar o Desactivar el Registo?")){
					return false;
				}
			});
		});
	</script>
@stop