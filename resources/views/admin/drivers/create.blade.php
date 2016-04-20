@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Add New Driver</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.drivers.index')}}">Drivers</a></li>
						<li class="active">New</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Driver Info</h4>
						</div>
						<div class="panel-body">
							@include('errors.form')
							<form method="POST" action="{{route('admin.drivers.store')}}" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="firstname" class="col-sm-3 control-label">First Name</label>
									<div class="col-sm-9">
										{{Form::text('firstname', '', ['id'=>'firstname', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="lastname" class="col-sm-3 control-label">Last Name</label>
									<div class="col-sm-9">
										{{Form::text('lastname', '', ['id'=>'lastname', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="rate" class="col-sm-3 control-label">Rate</label>
									<div class="col-sm-9">
										{{Form::text('rate', '', ['id'=>'rate', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="rate" class="col-sm-3 control-label">SSN Last 4</label>
									<div class="col-sm-9">
										{{Form::text('ssnlast4', '', ['name'=>'ssnlast4', 'id'=>'ssnlast4', 'class'=>'form-control'])}}
										<span class="text-muted">Used as the driver's password</span>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Create Driver', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
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