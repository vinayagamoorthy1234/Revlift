@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Add New Device</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.devices.index')}}">Devices</a></li>
						<li class="active">New</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Device Info</h4>
						</div>
						<div class="panel-body">
							@include('errors.form')
							<form method="POST" action="{{route('admin.devices.store')}}" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="truck_id" class="col-sm-3 control-label">Truck ID</label>
									<div class="col-sm-9">
										<?php
											$trucks = App\Truck::where('account_id', $currentUser->account->id)->orderBy('truck_number','asc')->pluck('truck_number', 'id');
										?>
										{{Form::select('truck_id', $trucks, '', ['id'=>'truck_id', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="type" class="col-sm-3 control-label">Type</label>
									<div class="col-sm-9">
										{{Form::select('type', ['Tablet'=>'Tablet', 'Printer'=>'Printer'], '', ['id'=>'type', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="serial" class="col-sm-3 control-label">Serial Number</label>
									<div class="col-sm-9">
										{{Form::text('serial', '', ['id'=>'serial', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="tag_number" class="col-sm-3 control-label">Tag number</label>
									<div class="col-sm-9">
										{{Form::text('tag_number', '', ['name'=>'tag_number', 'id'=>'tag_number', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Create Device', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
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