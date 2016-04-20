@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Add New Lease</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.leases.index')}}">Leases</a></li>
						<li class="active">New</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Lease Info</h4>
						</div>
						<div class="panel-body">
							@include('errors.form')
							<form method="POST" action="{{route('admin.leases.store')}}" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="operator_id" class="col-sm-3 control-label">Operator</label>
									<div class="col-sm-9">
										<?php
											$data = App\Operator::orderBy('name', 'ASC')->get();
											$list = [];
											foreach($data as $operator) {
												$list[$operator->id] = $operator->name.' ('.$operator->customer->abbreviation.')';
											}
										?>
										{{Form::select('operator_id', $list, '', ['id'=>'operator_id', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="billing_office_id" class="col-sm-3 control-label">Billing Office</label>
									<div class="col-sm-9">
										<?php
											$data = App\BillingOffice::leftJoin('customers', 'billing_offices.customer_id', '=', 'customers.id')->where('customers.account_id', $currentUser->account->id)->select('billing_offices.*')->get();
											$list = [];
											foreach($data as $billing_office) {
												$list[$billing_office->id] = $billing_office->name;
											}
										?>
										{{Form::select('billing_office_id', $list, '', ['id'=>'billing_office_id', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="name" class="col-sm-3 control-label">Lease Name</label>
									<div class="col-sm-9">
										{{Form::text('name', '', ['id'=>'name', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="number" class="col-sm-3 control-label">Lease Number</label>
									<div class="col-sm-9">
										{{Form::text('number', '', ['id'=>'number', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="county" class="col-sm-3 control-label">County</label>
									<div class="col-sm-9">
										{{Form::text('county', '', ['id'=>'county', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="state" class="col-sm-3 control-label">State</label>
									<div class="col-sm-9">
										{{Form::text('state', '', ['id'=>'state', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="section" class="col-sm-3 control-label">Section</label>
									<div class="col-sm-9">
										{{Form::text('section', '', ['id'=>'section', 'class'=>'form-control'])}}
									</div>
								</div>
								<br />
								<div class="form-group">
									<label for="latitude" class="col-sm-3 control-label">Latitude</label>
									<div class="col-sm-9">
										{{Form::text('latitude', '', ['id'=>'latitude', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="longitude" class="col-sm-3 control-label">Longitude</label>
									<div class="col-sm-9">
										{{Form::text('longitude', '', ['id'=>'longitude', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Create Lease', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
									</div>
								</div>
							</form>
						</div>
					</div>
				</div> <!-- end col -->
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Location</h4>
						</div>
						<div class="panel-body">
							<div id="map" style="margin-top:15px;min-height:455px"></div>
							<script>
							function initMap() {
								var map = new google.maps.Map(document.getElementById('map'), {
									zoom: 4,
									center: {lat: 39.833333, lng: -98.583333}
								});

								var marker = new google.maps.Marker({
									icon: {
										url: '/images/lease.png',
										scaledSize: new google.maps.Size(48, 48),
									}
								});

								var geocoder = new google.maps.Geocoder;
								var infowindow = new google.maps.InfoWindow;
								
								geocodeLatLng(geocoder, map, marker, infowindow);

								// LAT + LONG
								document.getElementById('latitude').addEventListener('change', function() {
									geocodeLatLng(geocoder, map, marker, infowindow);
								});
								document.getElementById('longitude').addEventListener('change', function() {
									geocodeLatLng(geocoder, map, marker, infowindow);
								});
							}

							function geocodeLatLng(geocoder, map, marker, infowindow) {
								var latitude = document.getElementById('latitude').value;
								var longitude = document.getElementById('longitude').value;

								var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};

								geocoder.geocode({'location': latlng}, function(results, status) {
									if (status === google.maps.GeocoderStatus.OK) {
										if(results[1]) {
											map.setCenter(results[0].geometry.location);
											map.setZoom(12);

											marker.setMap(map);
											marker.setPosition(results[0].geometry.location);
											marker.addListener('click', function() {
												// Listen for click on marker to show info
												infowindow.open(map, marker);
											});

											infowindow.setContent(results[0].formatted_address);
											infowindow.open(map, marker); // Auto open marker info
											
											// Set address in the fields provided so someone can override
											var formatted_address = results[0].formatted_address;
											var split = formatted_address.split(', ');
											$('#state').val(split[2].split(' ')[0]);

											console.log(results);
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
				</div><!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop