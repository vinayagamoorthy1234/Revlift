@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.headers.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Headers</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.headers.index')}}">Headers</a></li>
						<li class="active">Header {{$header->name}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">Header {{$header->name}}</h3>
					<a href="javascript:;" data-token="{{ csrf_token() }}" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Header</a>
					<a href="{{route('admin.headers.edit', ['id'=>$header->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Header</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Header Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Depot</strong></div>
										<div class="col-sm-9">
											{{$header->depot->name}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Header Name</strong></div>
										<div class="col-sm-9">
											{{$header->name}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Owner</strong></div>
										<div class="col-sm-9">
											{{$header->owner}}
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div id="map" style="width:100%;height: 200px"></div>
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
										var latitude = {{$header->depot->latitude}};
										var longitude = {{$header->depot->longitude}};

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

		</div> <!-- container -->
	</div> <!-- content -->
@stop