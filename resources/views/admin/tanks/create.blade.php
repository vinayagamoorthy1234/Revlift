@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Add New Tank</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.tanks.index')}}">Tanks</a></li>
						<li class="active">New</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Tank Info</h4>
						</div>
						<div class="panel-body">
							@include('errors.form')
							<form method="POST" action="{{route('admin.tanks.store')}}" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="lease_id" class="col-sm-3 control-label">Lease</label>
									<div class="col-sm-9">
										<?php
											$data = App\Lease::orderBy('name', 'ASC')->get();
											$list = [];
											foreach($data as $lease) {
												$list[$lease->id] = $lease->name.' ('.$lease->number.')';
											}
										?>
										{{Form::select('lease_id', $list, '', ['id'=>'lease_id', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="number" class="col-sm-3 control-label">Tank Number</label>
									<div class="col-sm-9">
										{{Form::text('number', '', ['id'=>'number', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="size" class="col-sm-3 control-label">Size</label>
									<div class="col-sm-9">
										{{Form::text('size', '', ['id'=>'size', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="bbls_per_inch" class="col-sm-3 control-label">BBLs Per Inch</label>
									<div class="col-sm-9">
										{{Form::text('bbls_per_inch', '1.67', ['id'=>'bbls_per_inch', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Create Tank', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
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