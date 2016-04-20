@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Edit Truck</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.trucks.index')}}">Trucks</a></li>
						<li><a href="{{route('admin.trucks.show', ['id'=>$truck->id])}}">Truck #{{$truck->truck_id}}</a></li>
						<li class="active">Edit</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Truck Info</h4>
						</div>
						<div class="panel-body">
							@include('errors.form')
							<form method="POST" action="{{route('admin.trucks.update', ['id'=>$truck->id])}}" class="form-horizontal">
								{{method_field('patch')}}
								{{csrf_field()}}
								<div class="form-group">
									<label for="truck_id" class="col-sm-3 control-label">Truck ID</label>
									<div class="col-sm-9">
										{{Form::text('truck_id', $truck->truck_id, ['id'=>'truck_id', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="owner" class="col-sm-3 control-label">Owner</label>
									<div class="col-sm-9">
										{{Form::text('owner', $truck->owner, ['id'=>'owner', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="rate" class="col-sm-3 control-label">Owner</label>
									<div class="col-sm-9">
										{{Form::text('rate', $truck->rate, ['id'=>'rate', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Submit Changes', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
									</div>
								</div>
							</form>
						</div>
					</div>
				</div> <!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop