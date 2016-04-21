@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Add New Depot</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.depots.index')}}">Depots</a></li>
						<li class="active">New</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Depot Info</h4>
						</div>
						<div class="panel-body">
							@include('errors.form')
							<form method="POST" action="{{route('admin.depots.store')}}" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="code" class="col-sm-3 control-label">Depot Code</label>
									<div class="col-sm-9">
										{{Form::text('code', '', ['id'=>'code', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="name" class="col-sm-3 control-label">Name</label>
									<div class="col-sm-9">
										{{Form::text('name', '', ['id'=>'name', 'class'=>'form-control'])}}
									</div>
								</div>
								<br />
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
									<div class="col-sm-offset-3 col-sm-9">
										<em>OR</em>
									</div>
								</div>
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
										{{Form::submit('Create Depot', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
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
										url: '/images/depot.png',
										scaledSize: new google.maps.Size(48, 48),
									}
								});

								var geocoder = new google.maps.Geocoder;
								var infowindow = new google.maps.InfoWindow;
								
								if($('#address').val().length > 1) {
									geocodeAddress(geocoder, map, marker, infowindow);
								} else {
									geocodeLatLng(geocoder, map, marker, infowindow);
								}

								// ADDRESS	
								document.getElementById('address').addEventListener('change', function() {
									geocodeAddress(geocoder, map, marker, infowindow);
								});
								document.getElementById('city').addEventListener('change', function() {
									geocodeAddress(geocoder, map, marker, infowindow);
								});
								document.getElementById('state').addEventListener('change', function() {
									geocodeAddress(geocoder, map, marker, infowindow);
								});
								document.getElementById('zip_code').addEventListener('change', function() {
									geocodeAddress(geocoder, map, marker, infowindow);
								});

								// LAT + LONG
								document.getElementById('latitude').addEventListener('change', function() {
									geocodeLatLng(geocoder, map, marker, infowindow);
								});
								document.getElementById('longitude').addEventListener('change', function() {
									geocodeLatLng(geocoder, map, marker, infowindow);
								});

                              //Setting latitude and langitude by click on the map
                               	google.maps.event.addListener(map, 'click', function(e) {
                              		document.getElementById('latitude').value =  e.latLng.lat();
									document.getElementById('longitude').value = e.latLng.lng();
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
											$('#address').val(split[0]);
											$('#city').val(split[1]);
											$('#state').val(split[2].split(' ')[0]);
											$('#zip_code').val(split[2].split(' ')[1]);

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

							function geocodeAddress(geocoder, map, marker, infowindow) {
								var address = document.getElementById('address').value;
								var city = document.getElementById('city').value;
								var state = document.getElementById('state').value;
								var zip_code = document.getElementById('zip_code').value;

								var full_address = address+' '+city+' '+state+' '+zip_code;

								geocoder.geocode({'address': full_address}, function(results, status) {
									if (status === google.maps.GeocoderStatus.OK) {
										map.setCenter(results[0].geometry.location);
										map.setZoom(12);

										marker.setMap(map);
										marker.setPosition(results[0].geometry.location);
										
										infowindow.setContent(results[0].formatted_address);
										infowindow.open(map, marker);

										$('#latitude').val(results[0].geometry.location.lat);
										$('#longitude').val(results[0].geometry.location.lng);

										console.log(results);
									} else {
										console.log('Geocode was not successful for the following reason: ' + status);
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