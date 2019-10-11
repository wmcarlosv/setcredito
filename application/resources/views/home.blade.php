@extends('adminlte::page')

@section('title', 'Escritorio')

@include('flash::message')

@section('content_header')
    <h1>Escritorio</h1>
@stop

@section('content')
    @if(Auth::user()->role == 'administrator')
    <div class="row">
    	<div class="col-md-6">
    		<div class="info-box">
			  <span class="info-box-icon bg-red"><i class="fas fa-user-tie"></i></span>
			  <div class="info-box-content">
			    <span class="info-box-text">Vendedores</span>
			    <span class="info-box-number">{{ $sellers->count() }}</span>
			  </div>
			</div>
    	</div>
    	<div class="col-md-6">
    		<div class="info-box">
			  <span class="info-box-icon bg-blue"><i class="fas fa-users-cog"></i></span>
			  <div class="info-box-content">
			    <span class="info-box-text">Puntos de Ventas</span>
			    <span class="info-box-number">{{ $sales_point->count() }}</span>
			  </div>
			</div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-md-12">
	    	<div class="panel panel-default">
	    		<div class="panel-heading">
	    			<h2>Ultimos Creditos Asignados</h2>
	    		</div>
	    		<div class="panel-body">
	    			<table class="table table-bordered table-striped data-table">
		    			<thead>
		    				<th>ID</th>
		    				<th>De</th>
		    				<th>Para</th>
		    				<th>Credito</th>
		    				<th>Con Variacion</th>
		    				<th>Tipo Variacion</th>
		    				<th>Monto Variacion</th>
		    				<th>Fecha/Hora Operación</th>
		    				<th></th>
		    			</thead>
		    			<tbody>
		    				@foreach($sales as $d)
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
    	</div>
    </div>
    @endif

    @if(Auth::user()->role == 'sales')
    <div class="row">
    	<div class="col-md-6">
    		<div class="info-box">
			  <span class="info-box-icon bg-red"><i class="fas fa-credit-card"></i></span>
			  <div class="info-box-content">
			    <span class="info-box-text">Creditos Disponibles</span>
			    <span class="info-box-number">{{ Auth::user()->total_credit }}</span>
			  </div>
			</div>
    	</div>
    	<div class="col-md-6">
    		<div class="info-box">
			  <span class="info-box-icon bg-blue"><i class="fas fa-users-cog"></i></span>
			  <div class="info-box-content">
			    <span class="info-box-text">Puntos de Ventas</span>
			    <span class="info-box-number">{{ $sales_point_by_seller->count() }}</span>
			  </div>
			</div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-md-12">
	    	<div class="panel panel-default">
	    		<div class="panel-heading">
	    			<h2>Ultimos Creditos Asignados</h2>
	    		</div>
	    		<div class="panel-body">
	    			<table class="table table-bordered table-striped data-table">
		    			<thead>
		    				<th>ID</th>
		    				<th>De</th>
		    				<th>Para</th>
		    				<th>Credito</th>
		    				<th>Con Variacion</th>
		    				<th>Tipo Variacion</th>
		    				<th>Monto Variacion</th>
		    				<th>Fecha/Hora Operación</th>
		    			</thead>
		    			<tbody>
			    		@foreach($sales_by_seller as $d)
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
    	</div>
    </div>
    @endif

    @if(Auth::user()->role == 'sales_point')
    <div class="row">
    	<div class="col-md-12">
    		<div class="info-box">
			  <span class="info-box-icon bg-red"><i class="fas fa-credit-card"></i></span>
			  <div class="info-box-content">
			    <span class="info-box-text">Creditos Disponibles</span>
			    <span class="info-box-number">{{ Auth::user()->total_credit }}</span>
			  </div>
			</div>
    	</div>
    </div>
    <div class="row">
    	<div class="col-md-12">
	    	<div class="panel panel-default">
	    		<div class="panel-heading">
	    			<h2>Ultimos Creditos Asignados</h2>
	    		</div>
	    		<div class="panel-body">
	    			<table class="table table-bordered table-striped data-table">
		    			<thead>
		    				<th>ID</th>
		    				<th>Conductor</th>
		    				<th>Credito</th>
		    				<th>Fecha/Hora Operación</th>
		    			</thead>
		    			<tbody>
		    				@foreach($provider_c as $pc)
		    				<tr>
		    					<td>{{ $pc->id }}</td>
		    					<td>{{ $pc->provider }}</td>
		    					<td>{{ $pc->credit }}</td>
		    					<td>{{ date('d-m-Y H:m:s',strtotime($pc->created_at)) }}</td>
		    				</tr>
		    				@endforeach
		    			</tbody>
		    		</table>
	    		</div>
	    	</div>
    	</div>
    </div>
    @endif
@stop
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$("table.data-table").DataTable();
		$('#flash-overlay-modal').modal();
	});
</script>
@stop