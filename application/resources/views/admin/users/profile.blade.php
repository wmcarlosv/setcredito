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
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Perfil</h2>
				</div>
				<div class="panel-body">
					{!! Form::open(['route' => 'change_profile', 'method' => 'POST', 'autocomplete' => 'off', 'files' => true]) !!}
						@if(Auth::user()->role == 'sales_point')
							<div class="form-group">
								<label for="social_reason">Razon Social:</label>
								<input type="text" class="form-control" name="social_reason" id="social_reason" value="{{ @Auth::user()->reason_social }}">
							</div>
						@endif
						<div class="form-group">
							<label for="name">Nombre:</label>
							<input type="text" class="form-control" name="name" id="name" value="{{ @Auth::user()->name }}">
						</div>
						<div class="form-group">
							<label for="last_name">Apellido:</label>
							<input type="text" class="form-control" name="last_name" id="last_name" value="{{ @Auth::user()->last_name }}">
						</div>
						<div class="form-group">
							<label for="email">Correo:</label>
							<input type="text" class="form-control" name="email" id="email" value="{{ @Auth::user()->email }}">
						</div>
						@if(Auth::user()->role != 'sales_point')
							<div class="form-group">
								<label for="avatar">Avatar:</label>
								@if(!empty(Auth::user()->avatar))
									<img class="thumbnail" src="{{ asset('application/storage/app/'.Auth::user()->avatar) }}" width="100" height="100"></img>
								@endif
								<input type="file" class="form-control" name="avatar" id="avatar" />
							</div>
						@endif
						<div class="form-group">
							<label for="phone">Telefono:</label>
							<input type="text" class="form-control" name="phone" id="phone" value="{{ @Auth::user()->phone }}">
						</div>
						<button class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
						<a class="btn btn-danger" href="{{ route('home') }}"><i class="fas fa-times-circle"></i> Cancelar</a>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Cambiar Contrase&ntilde;a</h2>
				</div>
				<div class="panel-body">
					{!! Form::open(['route' => 'change_password', 'method' => 'POST', 'autocomplet' => 'off']) !!}
						<div class="form-group">
							<label for="password">Contrase&ntilde;a</label>
							<input type="password" name="password" id="password" class="form-control">
						</div>
						<div class="form-group">
							<label for="password_confirmation">Repite Contrase&ntilde;a</label>
							<input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
						</div>
						<button class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
						<a class="btn btn-danger" href="{{ route('home') }}"><i class="fas fa-times-circle"></i> Cancelar</a>
					{!! Form::close() !!}
				</div>
			</div>	
		</div>
	</div>
@stop
