@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.customers.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Customers</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.customers.index')}}">Customers</a></li>
						<li class="active">{{$customer->name}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">{{$customer->name}}</h3>
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Customer</a>
					<a href="{{route('admin.customers.edit', ['id'=>$customer->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Customer</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Company Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Company Name</strong></div>
								<div class="col-sm-9">
									{{$customer->name}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Company Abbreviation</strong></div>
								<div class="col-sm-9">
									{{$customer->abbreviation}}
								</div>
							</div>
							@if(!empty($customer->email) || !empty($customer->phone))
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Contact Info</strong></div>
								<div class="col-sm-9">
									@if(!empty($customer->email)) {{$customer->email}}
									@elseif(!empty($customer->phone)) {{$customer->phone}}
									@endif
								</div>
							</div>
							@endif
							@if(!empty($customer->address) || !empty($customer->city) || !empty($customer->state) || !empty($customer->zip_code))
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Account Location</strong></div>
								<div class="col-sm-9">
									<span id="address">
										@if(!empty($customer->city))
											{{$customer->address.', '}}
										@endif
										@if(!empty($customer->city))
											{{$customer->city.', '}}
										@endif
										{{$customer->state.' '.$customer->zip_code}}
									</span>
								</div>
							</div>
							<div id="map" style="margin-top:15px;min-height:441px"></div>
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
							}

							function geocodeAddress(geocoder, resultsMap, marker) {
								var address = $('#address').text();

								geocoder.geocode({'address': address}, function(results, status) {
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
						@endif
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Operators</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center">Actions</th>
										<th>Name</th>
										<th>Created At</th>
										<th>Last Modified</th>
									</tr>
								</thead>
								<tbody>
									@foreach($customer->operators as $operator)
										<tr class="clickable-row" data-href="{{route('admin.operators.show', ['id'=>$operator->id])}}">
											<td class="text-center actions">
												<a href="{{route('admin.operators.show', ['id'=>$operator->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="#" title="Delete" class="text-danger"><i class="fa fa-trash"></i></a>
											</td>
											<td>{{$operator->name}}</td>
											<td>{{date('m/d/Y', strtotime($operator->created_at))}}</td>
											<td>{{date('m/d/Y', strtotime($operator->updated_at))}}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div> <!-- end col -->
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Billing Offices</h4>
						</div>
						<div class="panel-body">
							<table id="datatable2" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center">Actions</th>
										<th>Office Name</th>
										<th>Email</th>
										<th>Zip Code</th>
									</tr>
								</thead>
								<tbody>
									@foreach($customer->billing_offices as $office)
										<tr class="clickable-row" data-href="{{route('admin.billing.show', ['id'=>$office->id])}}">
											<td class="text-center actions">
												<a href="{{route('admin.billing.show', ['id'=>$office->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="#" title="Delete" class="text-danger"><i class="fa fa-trash"></i></a>
											</td>
											<td>{{$office->name}}</td>
											<td>{{date('m/d/Y', strtotime($office->created_at))}}</td>
											<td>{{date('m/d/Y', strtotime($office->updated_at))}}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div> <!-- end col -->
			</div> <!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop