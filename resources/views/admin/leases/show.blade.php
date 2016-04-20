@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.leases.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Leases</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.leases.index')}}">Leases</a></li>
						<li class="active">Lease #{{$lease->number}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">Lease #{{$lease->number}}</h3>
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Lease</a>
					<a href="{{route('admin.leases.edit', ['id'=>$lease->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Lease</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Lease Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Operator</strong></div>
										<div class="col-sm-9">
											{{$lease->operator->name}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Billing Office</strong></div>
										<div class="col-sm-9">
											{{$lease->billing_office->name}}
										</div>
									</div>
									<br />
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Lease Number</strong></div>
										<div class="col-sm-9">
											{{$lease->number}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Lease Name</strong></div>
										<div class="col-sm-9">
											{{$lease->name}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3 text-right"><strong>County</strong></div>
										<div class="col-sm-9">
											{{$lease->county}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3 text-right"><strong>State</strong></div>
										<div class="col-sm-9">
											{{$lease->state}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Section</strong></div>
										<div class="col-sm-9">
											{{$lease->section}}
										</div>
									</div>
									<br />
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Latitude</strong></div>
										<div class="col-sm-9" id="latitude">
											{{$lease->latitude}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-3 text-right"><strong>Longitude</strong></div>
										<div class="col-sm-9" id="longitude">
											{{$lease->longitude}}
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div id="map" style="min-height:250px"></div>
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
												url: '/images/lease.png',
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
							<h4 class="panel-title pull-left">Tanks</h4>
							<a href="#tanks.create" data-toggle="modal" data-target="#tanksModal" class="text-info pull-right" style="margin-right:10px;"><i class="fa fa-plus"></i> Add</a>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-hover table-bordered">
								<thead>
									<th class="text-center">Actions</th>
									<th>Tank Number</th>
									<th>Size</th>
									<th>BBLs Per Inch</th>
									<th>Last Modified</th>
								</thead>
								<tbody>
									@foreach($lease->tanks as $tank)
									<tr class="clickable-row" data-href="{{route('admin.tanks.show', ['id'=>$tank->id])}}">
										<td class="text-center">
											<a href="{{route('admin.tanks.show', ['id'=>$tank->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
											<a href="javascript:;" title="Delete" class="sa-warning tank text-danger" data-tank-id="{{$tank->id}}"><i class="fa fa-trash"></i></a>
										</td>
										<td>{{$tank->number}}</td>
										<td>{{$tank->size}}</td>
										<td>{{$tank->bbls_per_inch}}</td>
										<td>{{date('m/d/Y', strtotime($tank->updated_at))}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h4 class="panel-title pull-left">Distances/Mileages</h4>
							<a href="#mileage.create" data-toggle="modal" data-target="#mileageModal" class="text-info pull-right" style="margin-right:10px;"><i class="fa fa-plus"></i> Add</a>
						</div>
						<div class="panel-body">
							<table id="datatable2" class="table table-striped table-hover table-bordered">
								<thead>
									<th class="text-center">Actions</th>
									<th>Depot</th>
									<th>Distance</th>
								</thead>
								<tbody>
									@foreach($lease->mileages as $distance)
									<tr class="clickable-row" data-href="{{route('admin.mileages.show', ['id'=>$distance->id])}}">
										<td class="text-center">
											<a href="{{route('admin.mileages.show', ['id'=>$distance->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
											<a href="javascript:;" title="Delete" class="sa-warning text-danger" data-mileage-id="{{$distance->id}}"><i class="fa fa-trash"></i></a>
										</td>
										<td>{{$distance->depot->name}}</td>
										<td>{{$distance->mileage}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>

		</div> <!-- container -->
	</div> <!-- content -->

	{{-- Used for both modals --}}
	{{Form::hidden('lease_id', $lease->id, ['id'=>'lease_id'])}}

	<div id="tanksModal" class="modal fade" style="display:none">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h4 class="modal-title">Add Tank</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div id="form-errors"></div>
							<form method="POST" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="lease_name" class="col-sm-3 control-label">Lease</label>
									<div class="col-sm-9">
										{{Form::text('lease_name', $lease->name.' ('.$lease->number.')', ['disabled'=>'disabled', 'id'=>'lease_name', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="number" class="col-sm-3 control-label">Tank Number</label>
									<div class="col-sm-9">
										{{Form::text('number', '', ['id'=>'number', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="size" class="col-sm-3 control-label">Size</label>
									<div class="col-sm-9">
										{{Form::text('size', '', ['id'=>'size', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="bbls_per_inch" class="col-sm-3 control-label">BBLs Per Inch</label>
									<div class="col-sm-9">
										{{Form::text('bbls_per_inch', '1.67', ['id'=>'bbls_per_inch', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Create Tank', ['id'=>'submit-tank', 'class'=>'btn btn-primary pull-right'])}}
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="mileageModal" class="modal fade" style="display:none">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h4 class="modal-title">Add Mileage</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-6">
							<div id="form-errors"></div>
							<form method="POST" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="lease_name" class="col-sm-3 control-label">Lease</label>
									<div class="col-sm-9">
										{{Form::text('lease_name', $lease->name.' ('.$lease->number.')', ['disabled'=>'disabled', 'id'=>'lease_name', 'class'=>'form-control'])}}
									</div>
								</div>
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
											echo '<input type="hidden" name="longitude" id="dest-longitude" value="'.$depotData[0]['longitude'].'" />';
											echo '<input type="hidden" name="latitude" id="dest-latitude" value="'.$depotData[0]['latitude'].'" />';

											$depotList = [];
											foreach($depotData as $depot) {
												$depotList[$depot['id']] = $depot['name'];
											}

										?>
										{{Form::select('depot_id', $depotList, '', ['id'=>'depot_id', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="mileage" class="col-sm-3 control-label">Mileage</label>
									<div class="col-sm-9">
										{{Form::text('mileage', '', ['disabled'=>'disabled', 'id'=>'mileage', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Create Mileage', ['id'=>'submit-mileage', 'class'=>'btn btn-primary pull-right'])}}
									</div>
								</div>
							</form>
						</div>
						<div class="col-sm-6">
							<div id="mileage-map" style="min-height:255px"></div>
							<script>
								function initMap2() {
									initMap();
								  var map = new google.maps.Map(document.getElementById('mileage-map'), {
										zoom: 4,
										center: {lat: 39.833333, lng: -98.583333}
								  });

								  var service = new google.maps.DistanceMatrixService;

								  var markersArray = [];

								  var origins = [
								  	{lat: <?php echo $lease->latitude ?>, lng: <?php echo $lease->longitude ?>}
								  ];
								  var destinations = [
								  	{lat: parseFloat($('#dest-latitude').val()), lng: parseFloat($('#dest-longitude').val())}
								  ];
								  
								  console.log(origins);
								  console.log(destinations);
								  calculateDistance(service, origins, destinations, map, markersArray);

									document.getElementById('depot_id').addEventListener('change', function() {
										deleteMarkers(markersArray);
										var el = $(this)[0];
										console.log(el.value);
										console.log(depotObj);
										for (var i = depotObj.length - 1; i >= 0; i--) {
											if(depotObj[i]['id'] === el.value) {
												destinations = [
								  				{lat: parseFloat(depotObj[i]['latitude']), lng: parseFloat(depotObj[i]['longitude'])}
								  			];
												document.getElementById('dest-latitude').value = depotObj[i]['latitude'];
												document.getElementById('dest-longitude').value = depotObj[i]['longitude'];
												calculateDistance(service, origins, destinations, map, markersArray);
											} else {
												console.log('No Match');
											}
										}
									});
								}

								function calculateDistance(service, origins, destinations, map, markersArray) {
									service.getDistanceMatrix({
								    origins: origins,
								    destinations: destinations,
								    travelMode: google.maps.TravelMode.DRIVING,
								    unitSystem: google.maps.UnitSystem.IMPERIAL,
								    avoidHighways: false,
								    avoidTolls: false
								  }, function(response, status) {
								    if (status !== google.maps.DistanceMatrixStatus.OK) {
								      alert('Error was: ' + status);
								    } else {
								      var originList = response.originAddresses;
								      var destinationList = response.destinationAddresses;
								      deleteMarkers(markersArray);

										  var destinationIcon = {
												url: '/images/depot.png',
												scaledSize: new google.maps.Size(48, 48),
											};
										  var originIcon = {
												url: '/images/lease.png',
												scaledSize: new google.maps.Size(48, 48),
										  };

										  var geocoder = new google.maps.Geocoder;
										  var bounds = new google.maps.LatLngBounds;

								      var showGeocodedAddressOnMap = function(asDestination) {
								        var icon = asDestination ? destinationIcon : originIcon;
								        return function(results, status) {
								          if (status === google.maps.GeocoderStatus.OK) {
								            map.fitBounds(bounds.extend(results[0].geometry.location));
								            markersArray.push(new google.maps.Marker({
								              map: map,
								              position: results[0].geometry.location,
								              icon: icon
								            }));
								          } else {
								            alert('Geocode was not successful due to: ' + status);
								          }
								        };
								      };

								      for (var i = 0; i < originList.length; i++) {
								        var results = response.rows[i].elements;
								        geocoder.geocode({'address': originList[i]}, showGeocodedAddressOnMap(false));
								        for (var j = 0; j < results.length; j++) {
								          geocoder.geocode({'address': destinationList[j]}, showGeocodedAddressOnMap(true));
								          $('#mileage').val(results[j].distance.text.split(' ')[0]);
								        }
								      }
								    }
								  });
								}

								function deleteMarkers(markersArray) {
								  for (var i = 0; i < markersArray.length; i++) {
								    markersArray[i].setMap(null);
								  }
								  markersArray = [];
								}

							</script>
							<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvIIVslXmo9UvfnKhryqYQZBTNP1jHXYE&signed_in=true&callback=initMap2"></script>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop