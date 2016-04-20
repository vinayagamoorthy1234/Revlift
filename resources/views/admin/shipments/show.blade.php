@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.shipments.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Shipments</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.shipments.index')}}">Shipments</a></li>
						<li class="active">Shipment #{{$shipment->ticket_number}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">Shipment #{{$shipment->ticket_number}}</h3>
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Shipment</a>
					<a href="{{route('admin.shipments.edit', ['id'=>$shipment->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Shipment</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Shipment Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Shipment Number</strong></div>
								<div class="col-sm-9">
									{{$shipment->ticket_number}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Truck</strong></div>
								<div class="col-sm-9">
									{{$shipment->truck->truck_number}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Driver</strong></div>
								<div class="col-sm-9">
									{{$shipment->driver->firstname}}
								</div>
							</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop