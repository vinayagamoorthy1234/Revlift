@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Edit Header</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.headers.index')}}">Headers</a></li>
						<li><a href="{{route('admin.headers.show', ['id'=>$header->id])}}">Header {{$header->name}}</a></li>
						<li class="active">Edit</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Header Info</h4>
						</div>
						<div class="panel-body">
							@include('errors.form')
							<form method="POST" action="{{route('admin.headers.update', ['id'=>$header->id])}}" class="form-horizontal">
								{{method_field('patch')}}
								{{csrf_field()}}
								<div class="form-group">
									<label for="depot_id" class="col-sm-3 control-label">Depot</label>
									<div class="col-sm-9">
										<?php
											$data = App\Depot::orderBy('name', 'ASC')->get();

											$depotData = [];
											for($i=0;$i<count($data);$i++) {
												$depotData[$i]['id'] = $data[$i]->id;
												$depotData[$i]['name'] = $data[$i]->name.' ('.$data[$i]->code.')';
												$depotData[$i]['longitude'] = $data[$i]->longitude;
												$depotData[$i]['latitude'] = $data[$i]->latitude;
											}

											echo '<script>
												var depotObj = '.json_encode($depotData).';
												console.log(depotObj);
											</script>';
											echo '<input type="hidden" name="longitude" id="longitude" value="'.$depotData[0]['longitude'].'" />';
											echo '<input type="hidden" name="latitude" id="latitude" value="'.$depotData[0]['latitude'].'" />';

											$depotList = [];
											foreach($depotData as $depot) {
												$depotList[$depot['id']] = $depot['name'];
											}

										?>
										{{Form::select('depot_id', $depotList, $header->depot_id, ['id'=>'depot_id', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="name" class="col-sm-3 control-label">Name</label>
									<div class="col-sm-9">
										{{Form::text('name', $header->name, ['id'=>'name', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="owner" class="col-sm-3 control-label">Owner</label>
									<div class="col-sm-9">
										{{Form::text('owner', $header->owner, ['id'=>'owner', 'class'=>'form-control'])}}
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
								
								geocodeLatLng(geocoder, map, marker, infowindow);

								// LAT + LONG
								document.getElementById('latitude').addEventListener('change', function() {
									geocodeLatLng(geocoder, map, marker, infowindow);
								});
								document.getElementById('longitude').addEventListener('change', function() {
									geocodeLatLng(geocoder, map, marker, infowindow);
								});

								document.getElementById('depot_id').addEventListener('change', function() {
									var el = $(this)[0];
									// console.log(el.value);
									// console.log(depotObj);
									for (var i = depotObj.length - 1; i >= 0; i--) {
										if(depotObj[i]['id'] === el.value) {
											document.getElementById('latitude').value = depotObj[i]['latitude'];
											document.getElementById('longitude').value = depotObj[i]['longitude'];
											geocodeLatLng(geocoder, map, marker, infowindow);
										} else {
											console.log('No Match');
										}
									}
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