@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.accounts.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Accounts</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.accounts.index')}}">Accounts</a></li>
						<li class="active">{{$account->name}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">{{$account->name}}</h3>
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Account</a>
					<a href="{{route('admin.accounts.edit', ['id'=>$account->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Account</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Account Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Account Name</strong></div>
								<div class="col-sm-9">
									{{$account->name}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Account Owner</strong></div>
								<div class="col-sm-9">
									{{$account->owner}}
								</div>
							</div>
							@if(!empty($account->contact_name))
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Account Contact</strong></div>
								<div class="col-sm-9">
									@if(!empty($account->contact_email)) {{$account->contact_name}}: {{$account->contact_email}}
									@elseif(!empty($account->contact_phone)) {{$account->contact_name}}: {{$account->contact_phone}}
									@else {{$account->contact_name}}
									@endif
								</div>
							</div>
							@endif
							@if(!empty($account->address) || !empty($account->city) || !empty($account->state) || !empty($account->zip_code))
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Account Location</strong></div>
								<div class="col-sm-9">
									<span id="address">
										@if(!empty($account->city))
											{{$account->address.', '}}
										@endif
										@if(!empty($account->city))
											{{$account->city.', '}}
										@endif
										{{$account->state.' '.$account->zip_code}}
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
							<h4 class="panel-title">List of Users</h4>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th>Name</th>
										<th>Role</th>
										<th>Description</th>
										<th>Created At</th>
									</tr>
								</thead>
								<tbody>
									@for($i=0;$i<$account->users->count();$i++)
										<tr class="clickable-row" data-href="{{route('admin.users.show', ['id'=>$account->users[$i]->id])}}">
											<td>{{$account->users[$i]->firstname.' '.$account->users[$i]->lastname}}</td>
											<td>{{$account->users[$i]->role}}</td>
											<td>{{$account->users[$i]->description}}</td>
											<td>{{date('m/d/Y g:i a', strtotime($account->users[$i]->created_at))}}</td>
										</tr>
									@endfor
								</tbody>
							</table>
						</div>
					</div>
				</div> <!-- end col -->
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Tanks</h4>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-hover"></table>
						</div>
					</div>
				</div> <!-- end col -->
			</div> <!-- end row -->

			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Depots</h4>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-hover">
							</table>
						</div>
					</div>
				</div> <!-- end col -->
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Leases</h4>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-hover"></table>
						</div>
					</div>
				</div> <!-- end col -->
			</div> <!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop