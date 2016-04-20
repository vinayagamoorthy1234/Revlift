@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">All Leases <a href="{{route('admin.leases.create')}}" class="btn btn-info" style="margin-left:10px;"><i class="fa fa-plus"></i> Add</a></h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li class="active">Leases</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Leases</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th width="10%" class="text-center">Actions</th>
										<th>Number</th>
										<th>Name</th>
										<th>Lat</th>
										<th>Long</th>
										<th width="15%">Created At</th>
										<th width="15%">Last Modified</th>
									</tr>
								</thead>
								<tbody>
									<div style="display:none" id="token" data-token="{{csrf_token()}}"></div>
									@foreach($leases as $lease)
										<tr class="clickable-row" data-href="{{route('admin.leases.show', ['id'=>$lease->id])}}">
											<td class="text-center actions">
												<a href="{{route('admin.leases.show', ['id'=>$lease->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="javascript:;" title="Delete" class="sa-warning text-danger" data-lease-id="{{$lease->id}}"><i class="fa fa-trash"></i></a>
											</td>
											<td>{{$lease->number}}</td>
											<td>{{$lease->name}}</td>
											<td class="latitude">{{$lease->latitude}}</td>
											<td class="longitude">{{$lease->longitude}}</td>
											<td>{{date('m/d/Y', strtotime($lease->created_at))}}</td>
											<td>{{date('m/d/Y', strtotime($lease->updated_at))}}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div> <!-- end col -->
			</div> <!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Lease Map</h4>
						</div>
						<div class="panel-body">
							<div id="map" style="margin-top:15px;min-height:455px"></div>
							<script>
							function initMap() {
								var map = new google.maps.Map(document.getElementById('map'), {
									zoom: 4,
									center: {lat: 39.833333, lng: -98.583333}
								});

								var geocoder = new google.maps.Geocoder;
								var bounds = new google.maps.LatLngBounds();
								
								$('tbody tr').each(function() {
									$this = $(this);
									var latitude = $this.find(".latitude").text();
									var longitude = $this.find(".longitude").text();

									geocodeLatLng(geocoder, map, bounds, latitude, longitude);
								});
							}

							function geocodeLatLng(geocoder, map, bounds, latitude, longitude) {

								var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};

								geocoder.geocode({'location': latlng}, function(results, status) {
									if (status === google.maps.GeocoderStatus.OK) {
										if(results[1]) {
											var marker = new google.maps.Marker({
												map: map,
												position: latlng,
												icon: {
													url: '/images/lease.png',
													scaledSize: new google.maps.Size(48, 48),
												}
											});

											marker.addListener('click', function() {
												// Listen for click on marker to show info
												infowindow.open(map, marker);
											});

											var infowindow = new google.maps.InfoWindow();
											infowindow.setContent(results[0].formatted_address);
											infowindow.open(map, marker); // Auto open marker info

											bounds.extend(marker.position);
											map.fitBounds(bounds);
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

		</div> <!-- container -->
	</div> <!-- content -->
@stop