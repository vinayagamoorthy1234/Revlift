@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Edit driver</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.drivers.index')}}">Drivers</a></li>
						<li><a href="{{route('admin.drivers.show', ['id'=>$driver->id])}}">{{$driver->firstname.' '.$driver->lastname}}</a></li>
						<li class="active">Edit</li>
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
							<form method="POST" action="{{route('admin.drivers.update', ['id'=>$driver->id])}}" class="form-horizontal">
								{{method_field('patch')}}
								{{csrf_field()}}
								<div class="form-group">
									<label for="firstname" class="col-sm-3 control-label">First Name</label>
									<div class="col-sm-9">
										{{Form::text('firstname', $driver->firstname, ['id'=>'firstname', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="lastname" class="col-sm-3 control-label">Last Name</label>
									<div class="col-sm-9">
										{{Form::text('lastname', $driver->lastname, ['id'=>'lastname', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="rate" class="col-sm-3 control-label">Rate</label>
									<div class="col-sm-9">
										{{Form::text('rate', $driver->rate, ['id'=>'rate', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Update Driver', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
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