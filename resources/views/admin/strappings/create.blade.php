@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Add New Tank Strapping</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.strappings.index')}}">Tank Strappings</a></li>
						<li class="active">New</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Tank Strapping Info</h4>
						</div>
						<div class="panel-body">
							@include('errors.form')
							<form method="POST" action="{{route('admin.strappings.store')}}" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="tank_id" class="col-sm-3 control-label">Tank</label>
									<div class="col-sm-9">
										<?php
											$data = App\Tank::orderBy('number', 'ASC')->get();
											$list = [];
											foreach($data as $tank) {
												$list[$tank->id] = $tank->number;
											}
										?>
										{{Form::select('tank_id', $list, '', ['id'=>'tank_id', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="qtr" class="col-sm-3 control-label">Qtr Inches</label>
									<div class="col-sm-9">
										{{Form::text('qtr', '', ['id'=>'qtr', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="rate" class="col-sm-3 control-label">Rate</label>
									<div class="col-sm-9">
										{{Form::text('rate', '', ['id'=>'rate', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="rateAbove" class="col-sm-3 control-label">Rate Above</label>
									<div class="col-sm-9">
										{{Form::text('rateAbove', '', ['id'=>'rateAbove', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="cumulative_bbls" class="col-sm-3 control-label">Cumulative BBLs</label>
									<div class="col-sm-9">
										{{Form::text('cumulative_bbls', '', ['id'=>'cumulative_bbls', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="source" class="col-sm-3 control-label">Strapping Source</label>
									<div class="col-sm-9">
										{{Form::text('source', '', ['id'=>'source', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Create Tank Strapping', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
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