@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.operators.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Operators</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.operators.index')}}">Operators</a></li>
						<li class="active">{{$operator->name}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">{{$operator->name}}</h3>
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Operator</a>
					<a href="{{route('admin.operators.edit', ['id'=>$operator->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Operator</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Operator Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Operator Name</strong></div>
								<div class="col-sm-9">
									{{$operator->name}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Customer</strong></div>
								<div class="col-sm-9">
									{{$operator->customer->name}}
								</div>
							</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop