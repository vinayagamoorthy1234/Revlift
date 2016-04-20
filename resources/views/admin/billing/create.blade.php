@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Add New Billing Office</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.billing.index')}}">Billing Offices</a></li>
						<li class="active">New</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Billing Office Info</h4>
						</div>
						<div class="panel-body">
							@include('errors.form')
							<form method="POST" action="{{route('admin.billing.store')}}" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="name" class="col-sm-3 control-label">Office Name</label>
									<div class="col-sm-9">
										{{Form::text('name', '', ['id'=>'name', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="customer" class="col-sm-3 control-label">Customer</label>
									<div class="col-sm-9">
										<?php
											$data = App\Customer::where('account_id', $currentUser->account->id)->orderBy('name', 'ASC')->get();
											$list = [];
											foreach($data as $customer) {
												$list[$customer->id] = $customer->name;
											}
										?>
										{{Form::select('customer', $list, '', ['id'=>'customer', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="contact_email" class="col-sm-3 control-label">Email</label>
									<div class="col-sm-9">
										{{Form::text('email', '', ['id'=>'email', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="phone" class="col-sm-3 control-label">Phone</label>
									<div class="col-sm-9">
										{{Form::text('phone', '', ['id'=>'phone', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="address" class="col-sm-3 control-label">Address</label>
									<div class="col-sm-9">
										{{Form::text('address', '', ['id'=>'address', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="city" class="col-sm-3 control-label">City</label>
									<div class="col-sm-9">
										{{Form::text('city', '', ['id'=>'city', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="state" class="col-sm-3 control-label">State</label>
									<div class="col-sm-9">
										{{Form::text('state', '', ['id'=>'state', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="zip_code" class="col-sm-3 control-label">Zip Code</label>
									<div class="col-sm-9">
										{{Form::text('zip_code', '', ['id'=>'zip_code', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Create Billing Office', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
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
							<p>Location is based on the given address/city/state/zip to the left</p>
							<div id="map" style="margin-top:15px;min-height:455px"></div>
							<script>
							function initMap() {
								var map = new google.maps.Map(document.getElementById('map'), {
									zoom: 4,
									center: {lat: 39.833333, lng: -98.583333}
								});

								var marker = new google.maps.Marker({
									map: map,
									position: map.center
								});
								var geocoder = new google.maps.Geocoder();
								geocodeAddress(geocoder, map, marker);

								document.getElementById('address').addEventListener('change', function() {
									geocodeAddress(geocoder, map, marker);
								});
								document.getElementById('city').addEventListener('change', function() {
									geocodeAddress(geocoder, map, marker);
								});
								document.getElementById('state').addEventListener('change', function() {
									geocodeAddress(geocoder, map, marker);
								});
								document.getElementById('zip_code').addEventListener('change', function() {
									geocodeAddress(geocoder, map, marker);
								});
							}

							function geocodeAddress(geocoder, resultsMap, marker) {
								var address = document.getElementById('address').value;
								var city = document.getElementById('city').value;
								var state = document.getElementById('state').value;
								var zip_code = document.getElementById('zip_code').value;

								var full_address = address+' '+city+' '+state+' '+zip_code;

								geocoder.geocode({'address': full_address}, function(results, status) {
									if (status === google.maps.GeocoderStatus.OK) {
										resultsMap.setCenter(results[0].geometry.location);
										resultsMap.setZoom(12);
										marker.setPosition(results[0].geometry.location);
									} else {
										console.log('Geocode was not successful for the following reason: ' + status);
									}
								});
							}

							</script>
							<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvIIVslXmo9UvfnKhryqYQZBTNP1jHXYE&signed_in=true&callback=initMap"></script>
						</div>
					</div>
				</div>
			</div>

		</div> <!-- container -->
	</div> <!-- content -->
@stop