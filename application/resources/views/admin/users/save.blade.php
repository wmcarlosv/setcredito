@extends('adminlte::page')

@section('title', $title)

@section('content')
	@if($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2>{{ $title }}</h2>
		</div>
		<div class="panel-body">
			@if($method == 'insert')
				{!! Form::open(['route' => 'users.store', 'method' => 'POST', 'autocomplete' => 'off', 'files' => true]) !!}
			@else
				{!! Form::open(['route' => ['users.update',@$data->id], 'method' => 'PUT', 'autocomplete' => 'off', 'files' => true]) !!}
			@endif
				@if(Auth::user()->role == 'administrator')
				<div class="form-group">
					<label for="role">Rol</label>
					<select name="role" id="role" class="form-control">
						<option value="administrator" @if(@$data->role == 'administrator') selected='selected' @endif>Administrador</option>
						<option value="sales" @if(@$data->role == 'sales') selected='selected' @endif>Vendedor</option>
						<option value="sales_point" @if(@$data->role == 'sales_point') selected='selected' @endif>Punto de Venta</option>
					</select>
				</div>
				@else
					<input type="hidden" name="role" id="role" value="sales_point" />
				@endif
				<div class="form-group">
					<label for="name">Nombre</label>
					<input type="text" id="name" name="name" value="{{ @$data->name }}" class="form-control" />
				</div>
				<div class="form-group">
					<label for="last_name">Apellido</label>
					<input type="text" id="last_name" name="last_name" value="{{ @$data->last_name }}"  class="form-control" />
				</div>

				<div class="form-group" id="only_sp">
					<label for="reason_social">Rason Social</label>
					<input type="text" id="reason_social" value="{{ @$data->reason_social }}"  name="reason_social" class="form-control" />
				</div>

				<div class="form-group">
					<label for="email">Correo</label>
					<input type="text" id="email" name="email" value="{{ @$data->email }}"  class="form-control" />
				</div>

				<div class="form-group no-sp">
					<label for="avatar">Avatar</label>
					@if(!empty(@$data->avatar))
						<img class="thumbnail" src="{{ asset('application/storage/app/'.@$data->avatar) }}" width="100" height="100" />
					@endif
					<input type="file" id="avatar" name="avatar" class="form-control" />
				</div>

				<div class="form-group">
					<label for="phone">Phone</label>
					<input type="text" id="phone" name="phone"  value="{{ @$data->phone }}"  class="form-control" />
				</div>
				<button class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
				<a class="btn btn-danger" href="{{ route('users.index') }}"><i class="fas fa-times-circle"></i> Cancelar</a>
			{!! Form::close() !!}
		</div>
	</div>
@stop
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		@if(Auth::user()->role == 'administrator')
			$("#only_sp").hide();
		@else
			$(".no-sp").hide();
		@endif

		$("#role").change(function(){
			if($(this).val() == 'sales_point'){
				$("#only_sp").show();
				$(".no-sp").hide();
			}else{
				$("#only_sp").hide();
				$(".no-sp").show();
			}
		});

	});
</script>
@stop