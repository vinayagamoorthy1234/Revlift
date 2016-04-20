@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Edit Operator</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.operators.index')}}">Operators</a></li>
						<li><a href="{{route('admin.operators.show', ['id'=>$operator->id])}}">{{$operator->name}}</a></li>
						<li class="active">Edit</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Company Info</h4>
						</div>
						<div class="panel-body">
							@include('errors.form')
							<form method="POST" action="{{route('admin.operators.update', ['id'=>$operator->id])}}" class="form-horizontal">
								{{method_field('patch')}}
								{{csrf_field()}}
								<div class="form-group">
									<label for="name" class="col-sm-3 control-label">Operator Name</label>
									<div class="col-sm-9">
										{{Form::text('name', $operator->name, ['id'=>'name', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="customer" class="col-sm-3 control-label">Customer</label>
									<div class="col-sm-9">
										<?php
											$data = App\Customer::orderBy('name', 'ASC')->get();
											$list = [];
											foreach($data as $account) {
												$list[$account->id] = $account->name;
											}
										?>
										{{Form::select('customer', $list, $operator->customer->id, ['id'=>'marketing_company', 'class'=>'form-control'])}}
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