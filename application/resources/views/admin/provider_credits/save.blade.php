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
			{!! Form::open(['route' => 'provider-credits.store', 'method' => 'POST', 'autocomplete' => 'off', 'files' => true]) !!}
				<div class="form-group">
					<label for="provider">Conductor</label>
					<select id="provider" name="provider" class="form-control basic-select">
						<option></option>
						@foreach($providers as $p)
							<option value="{{ $p->mobile }}">{{ $p->first_name.' '.$p->last_name.' '.$p->email.' '.$p->mobile }} (Balance => {{ $p->wallet_balance }})</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="credit">Credito</label>
					<input type="text" id="credit" name="credit" value="{{ @$data->credit }}"  class="form-control" />
				</div>
				<button class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
				<a class="btn btn-danger" href="{{ route('provider-credits.index') }}"><i class="fas fa-times-circle"></i> Cancelar</a>
			{!! Form::close() !!}
		</div>
	</div>
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('select.basic-select').select2();
	});
</script>
@stop