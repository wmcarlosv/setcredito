@extends('adminlte::page')

@section('title', $title)

@section('css')
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
@stop

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
				{!! Form::open(['route' => 'sales.store', 'method' => 'POST', 'autocomplete' => 'off', 'files' => true]) !!}
				<div class="form-group">
					<label for="user_to">Para:</label>
					<select class="form-control basic-select" name="user_to" id="user_to">
						<option>-</option>
						@foreach($users as $user)
							<option value="{{ $user->id }}">{{ $user->name.' '.$user->last_name }} ({{ $user->role }})</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="credits">Creditos:</label>
					<input type="text" name="credits" id="credits" class="form-control" />
				</div>
				<div class="form-group">
					<label for="is_variation">Con Variacion:</label>
					<select class="form-control" name="is_variation" id="is_variation">
						<option value='0'>No</option>
						<option value='1'>Si</option>
					</select>
				</div>
				<div class="form-group" id="vt">
					<label for="variation_type">Tipo de Variacion:</label>
					<select class="form-control" name="variation_type" id="variation_type">
						<option value=''>-</option>
						<option value="increment">Incremento</option>
						<option value="decrement">Descuento</option>
					</select>
				</div>
				<div class="form-group" id="vrt">
					<label for="variation">Variacion:</label>
					<input type="text" name="variation" id="variation" class="form-control" />
				</div>
				<button class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
				<a class="btn btn-danger" href="{{ route('sales.index') }}"><i class="fas fa-times-circle"></i> Cancelar</a>
			{!! Form::close() !!}
		</div>
	</div>
@stop
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#vt, #vrt").hide();

		$('select.basic-select').select2();
		$("#is_variation").change(function(){
			if($(this).val() == '1'){
				$("#vt, #vrt").show();
			}else{
				$("#vt, #vrt").hide();
			}
		});
	});
</script>
@stop