@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Add New Truck</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.trucks.index')}}">Trucks</a></li>
						<li class="active">New</li>
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
							<form method="POST" action="{{route('admin.trucks.store')}}" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="truck_number" class="col-sm-3 control-label">Truck ID</label>
									<div class="col-sm-9">
										{{Form::text('truck_number', '', ['id'=>'truck_number', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="owner" class="col-sm-3 control-label">Owner</label>
									<div class="col-sm-9">
										{{Form::text('owner', $currentUser->account->name, ['id'=>'owner', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="rate" class="col-sm-3 control-label">Rate</label>
									<div class="col-sm-9">
										{{Form::text('rate', '1', ['id'=>'rate', 'class'=>'form-control'])}}
										<span class="text-muted">Default is 1</span>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Create Truck', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
									</div>
								</div>
							</form>
						</div>
					</div>
				</div> <!-- end col -->
			</div>

		</div> <!-- container -->
	</div> <!-- content -->
@stop