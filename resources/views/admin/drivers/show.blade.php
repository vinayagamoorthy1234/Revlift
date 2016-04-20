@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.drivers.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Drivers</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.drivers.index')}}">Drivers</a></li>
						<li class="active">{{$driver->firstname.' '.$driver->lastname}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">{{$driver->firstname.' '.$driver->lastname}}</h3>
					<a href="{{route('admin.drivers.edit', ['id'=>$driver->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Driver</a>
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Driver</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">driver Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Company</strong></div>
								<div class="col-sm-9">
									<a href="{{route('admin.accounts.show', ['id'=>$driver->account->id])}}">{{$driver->account->name}}</a>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Rate</strong></div>
								<div class="col-sm-9">
									{{$driver->rate}}
								</div>
							</div>
							@if(!empty($driver->phone))
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Phone</strong></div>
								<div class="col-sm-9">
									{{$driver->phone}}
								</div>
							</div>
							@endif
							@if(!empty($driver->description))
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Description</strong></div>
								<div class="col-sm-9">
									{{$driver->description}}
								</div>
							</div>
							@endif
						</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop