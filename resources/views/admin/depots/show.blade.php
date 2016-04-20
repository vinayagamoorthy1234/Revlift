@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.depots.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Depots</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.depots.index')}}">Depots</a></li>
						<li class="active">Depot {{$depot->code}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">Depot {{$depot->code}}</h3>
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Depot</a>
					<a href="{{route('admin.depots.edit', ['id'=>$depot->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Depot</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Depot Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Depot Code</strong></div>
										<div class="col-sm-9">
											{{$depot->code}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Name</strong></div>
										<div class="col-sm-9">
											{{$depot->name}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Latitude</strong></div>
										<div class="col-sm-9" id="latitude">
											{{$depot->latitude}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Longitude</strong></div>
										<div class="col-sm-9" id="longitude">
											{{$depot->longitude}}
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div id="map" style="margin-top:15px;min-height:250px"></div>
									<script>
									function initMap() {
										var map = new google.maps.Map(document.getElementById('map'), {
											zoom: 4,
											center: {lat: 39.833333, lng: -98.583333}
										});

										var marker = new google.maps.Marker({
											map: map,
											position: map.center,
											icon: {
												url: '/images/depot.png',
												scaledSize: new google.maps.Size(48, 48),
											}
										});
										var geocoder = new google.maps.Geocoder;
										var infowindow = new google.maps.InfoWindow;
										
										geocodeLatLng(geocoder, map, marker, infowindow);
									}

									function geocodeLatLng(geocoder, map, marker, infowindow) {
										var latitude = $('#latitude').text();
										var longitude = $('#longitude').text();

										var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
										console.log(latlng);

										geocoder.geocode({'location': latlng}, function(results, status) {
											if (status === google.maps.GeocoderStatus.OK) {
												if(results[1]) {
													map.setCenter(results[0].geometry.location);
													map.setZoom(7);
													marker.setPosition(results[0].geometry.location);
													infowindow.setContent(results[0].formatted_address);
													infowindow.open(map, marker);
												}
												else {
													console.log('No Results Found');
												}
											} else {
												console.log('Geocode failed due to: ' + status);
											}
										});
									}

									</script>
									<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvIIVslXmo9UvfnKhryqYQZBTNP1jHXYE&signed_in=true&callback=initMap"></script>
								</div>
							</div>
						</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h4 class="panel-title pull-left">Depot Allocation</h4>
							<a href="#allocation.create" data-toggle="modal" data-target="#allocationModal" class="text-info pull-right" style="margin-right:10px;"><i class="fa fa-plus"></i> Add</a>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-hover table-bordered">
								<thead>
									<th>Actions</th>
									<th>BBLs</th>
									<th>BBL Revised</th>
									<th>Allocation MM/YY</th>
								</thead>
								<tbody>
									@foreach($allocations as $allocation)
									<tr class="clickable-row" data-href="{{route('admin.allocations.show', ['id'=>$allocation->id])}}">
										<td class="text-center">
											<a href="{{route('admin.allocations.show', ['id'=>$allocation->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
											<a href="javascript:;" title="Delete" class="sa-warning allocation text-danger" data-allocation-id="{{$allocation->id}}"><i class="fa fa-trash"></i></a>
										</td>
										<td>{{$allocation->bbls}}</td>
										<td>{{$allocation->bbls_revised}}</td>
										<td>{{date('m/Y', strtotime($allocation->month_year))}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>					
				</div><!-- end col -->
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h4 class="panel-title pull-left">Depot Headers</h4>
							<a href="#header.create" data-toggle="modal" data-target="#headerModal" class="text-info pull-right" style="margin-right:10px;"><i class="fa fa-plus"></i> Add</a>
						</div>
						<div class="panel-body">
							<table id="datatable2" class="table table-striped table-hover table-bordered">
								<thead>
									<th class="text-center">Actions</th>
									<th>Header Name</th>
									<th>Owner</th>
									<th>Last Modified</th>
								</thead>
								<tbody>
									@foreach($headers as $header)
									<tr class="clickable-row" data-href="{{route('admin.headers.show', ['id'=>$header->id])}}">
										<td class="text-center">
											<a href="{{route('admin.headers.show', ['id'=>$header->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
											<a href="javascript:;" title="Delete" class="sa-warning header text-danger" data-header-id="{{$header->id}}"><i class="fa fa-trash"></i></a>
										</td>
										<td>{{$header->name}}</td>
										<td>{{$header->owner}}</td>
										<td>{{date('m/d/Y', strtotime($header->updated_at))}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->

	{{-- Used for both modals --}}
	{{Form::hidden('depot_id', $depot->id, ['id'=>'depot_id'])}}

	<div id="headerModal" class="modal fade" style="display:none">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h4 class="modal-title">Add Depot Header</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div id="form-errors"></div>
							<form method="POST" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="depot_name" class="col-sm-3 control-label">Depot</label>
									<div class="col-sm-9">
										{{Form::text('depot_name', $depot->name.' ('.$depot->code.')', ['disabled'=>'disabled', 'id'=>'depot_name', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="name" class="col-sm-3 control-label">Name</label>
									<div class="col-sm-9">
										{{Form::text('name', '', ['id'=>'name', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="owner" class="col-sm-3 control-label">Owner</label>
									<div class="col-sm-9">
										{{Form::text('owner', '', ['id'=>'owner', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Create Depot Header', ['id'=>'submit-header', 'class'=>'btn btn-primary pull-right'])}}
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="allocationModal" class="modal fade" style="display:none">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h4 class="modal-title">Add Depot Allocation</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div id="form-errors"></div>
							<form method="POST" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="depot_name" class="col-sm-3 control-label">Depot</label>
									<div class="col-sm-9">
										{{Form::text('depot_name', $depot->name.' ('.$depot->code.')', ['disabled'=>'disabled', 'id'=>'depot_name', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="bbls" class="col-sm-3 control-label">BBLs</label>
									<div class="col-sm-9">
										{{Form::text('bbls', '', ['class'=>'form-control bbls'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="bbls_revised" class="col-sm-3 control-label">BBLs Revised</label>
									<div class="col-sm-9">
										{{Form::text('bbls_revised', '', ['class'=>'form-control bbls_revised'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="month_year" class="col-sm-3 control-label">Allocation Date</label>
									<div class="col-sm-9">
										{{Form::date('month_year', date('Y-m-d', strtotime('today')), ['class'=>'form-control month_year'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="comments" class="col-sm-3 control-label">Comments</label>
									<div class="col-sm-9">
										{{Form::textarea('comments', '', ['rows' => '5', 'class'=>'form-control comments'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Create Depot Allocation', ['id'=>'submit-allocation', 'class'=>'btn btn-primary pull-right'])}}
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop