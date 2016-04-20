@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.devices.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Devices</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.devices.index')}}">Devices</a></li>
						<li class="active">{{$device->serial}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">Device {{$device->serial}}</h3>
					<a href="{{route('admin.devices.edit', ['id'=>$device->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Device</a>
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Device</a>
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Device Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Type</strong></div>
								<div class="col-sm-9">
									{{$device->type}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Truck</strong></div>
								<div class="col-sm-9">
									<a href="{{route('admin.trucks.show', ['id'=>$device->truck_id])}}">{{$device->truck->truck_number}}</a>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Serial</strong></div>
								<div class="col-sm-9">
									{{$device->serial}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Tag</strong></div>
								<div class="col-sm-9">
									{{$device->tag_number}}
								</div>
							</div>
						</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop