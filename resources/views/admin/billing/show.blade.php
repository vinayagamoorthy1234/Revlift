@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.billing.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Billing Offices</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.billing.index')}}">Billing Offices</a></li>
						<li class="active">{{$office->name}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">{{$office->name}}</h3>
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Office</a>
					<a href="{{route('admin.billing.edit', ['id'=>$office->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Office</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Office Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-6">
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Office Name</strong></div>
										<div class="col-sm-8">
											{{$office->name}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Company</strong></div>
										<div class="col-sm-8">
											{{$office->customer->name}}
										</div>
									</div>
									@if(!empty($office->email) || !empty($office->phone))
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Contact Info</strong></div>
										<div class="col-sm-8">
											@if(!empty($office->email)) {{$office->email}}
											@elseif(!empty($office->phone)) {{$office->phone}}
											@endif
										</div>
									</div>
									@endif
									@if(!empty($office->address) || !empty($office->city) || !empty($office->state) || !empty($office->zip_code))
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Location</strong></div>
										<div class="col-sm-8">
											<span id="address">
												@if(!empty($office->city))
													{{$office->address.', '}}
												@endif
												@if(!empty($office->city))
													{{$office->city.', '}}
												@endif
												{{$office->state.' '.$office->zip_code}}
											</span>
										</div>
									</div>
									@endif
								</div>
								<div class="col-sm-6">
									<div id="map" style="min-height:255px"></div>
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
							</div>
						</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h4 class="panel-title pull-left">Rates/Fees</h4>
							<a href="#rate.create" data-toggle="modal" data-target="#rateModal" class="text-info pull-right" style="margin-right:10px;"><i class="fa fa-plus"></i> Add</a>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center">Actions</th>
										<th>Nickname</th>
										<th>Office</th>
										<th>FSC</th>
										<th>Discount</th>
									</tr>
								</thead>
								<tbody>
									@foreach($office->rates as $rate)
										<tr class="clickable-row" data-href="{{route('admin.rates.show', ['id'=>$rate->id])}}">
											<td class="text-center actions">
												<a href="{{route('admin.rates.show', ['id'=>$rate->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="#" title="Delete" class="text-danger"><i class="fa fa-trash"></i></a>
											</td>
											<td>{{$rate->name}}</td>
											<td>{{$rate->billing_office->name}}</td>
											<td>{{$rate->fsc}}</td>
											<td>{{$rate->discount}}</td>
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
							<h4 class="panel-title">Leases</h4>
						</div>
						<div class="panel-body">
							<table id="datatable2" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center">Actions</th>
										<th>Name</th>
										<th>Number</th>
										<th>State</th>
										<th>Section</th>
									</tr>
								</thead>
								<tbody>
									@foreach($office->leases as $lease)
										<tr class="clickable-row" data-href="{{route('admin.leases.show', ['id'=>$lease->id])}}">
											<td class="text-center actions">
												<a href="{{route('admin.leases.show', ['id'=>$lease->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="#" title="Delete" class="text-danger"><i class="fa fa-trash"></i></a>
											</td>
											<td>{{$lease->name}}</td>
											<td>{{$lease->number}}</td>
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

		</div> <!-- container -->
	</div> <!-- content -->

	<div id="rateModal" class="modal fade" style="display:none">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h4 class="modal-title">Add Rate for {{$office->name}}</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12">
							<div id="form-errors"></div>
							<form method="POST" id="admin_rate_form" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="billing_office" class="col-sm-3 control-label">Billing Office</label>
									<div class="col-sm-9">
										<input type="hidden" id="office_id" value="{{$office->id}}">
										{{Form::text('billing_office', $office->name, ['disabled'=>'disabled', 'id'=>'billing_office', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="name" class="col-sm-3 control-label">Nickname</label>
									<div class="col-sm-9">
										{{Form::text('name', '', ['id'=>'name', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="chain_up_fee" class="col-sm-3 control-label">Chain Up Fee</label>
									<div class="col-sm-9">
										{{Form::text('chain_up_fee', '', ['id'=>'chain_up_fee', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="chain_up_pay" class="col-sm-3 control-label">Chain Up Driver Pay</label>
									<div class="col-sm-9">
										{{Form::text('chain_up_pay', '', ['id'=>'chain_up_pay', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="demm_fee" class="col-sm-3 control-label">Demurrage Fee</label>
									<div class="col-sm-9">
										{{Form::text('demm_fee', '', ['id'=>'demm_fee', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="nc_demm_hrs" class="col-sm-3 control-label">No Charge Demurrage Hrs</label>
									<div class="col-sm-9">
										{{Form::text('nc_demm_hrs', '', ['id'=>'nc_demm_hrs', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="divert_fee" class="col-sm-3 control-label">Divert Fee</label>
									<div class="col-sm-9">
										{{Form::text('divert_fee', '', ['id'=>'divert_fee', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="reject_fee" class="col-sm-3 control-label">Reject Fee</label>
									<div class="col-sm-9">
										{{Form::text('reject_fee', '', ['id'=>'reject_fee', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="split_fee" class="col-sm-3 control-label">Split Fee</label>
									<div class="col-sm-9">
										{{Form::text('split_fee', '', ['id'=>'split_fee', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="masking_fee" class="col-sm-3 control-label">Masking Fee</label>
									<div class="col-sm-9">
										{{Form::text('masking_fee', '', ['id'=>'masking_fee', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="fsc_formula" class="col-sm-3 control-label">Fuel Surcharge Formula</label>
									<div class="col-sm-9">
										{{Form::text('fsc_formula', '', ['id'=>'fsc_formula', 'class'=>'form-control'])}}
										<span class="help-block">Must include <u>price</u> and <u>base_rate</u> where you want to include those values in the formula</span>
									</div>
								</div>
								<div class="form-group">
									<label for="min_bbls" class="col-sm-3 control-label">Min Barrels</label>
									<div class="col-sm-9">
										{{Form::text('min_bbls', '', ['id'=>'min_bbls', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="discount" class="col-sm-3 control-label">Discount</label>
									<div class="col-sm-9">
										{{Form::text('discount', '', ['id'=>'discount', 'class'=>'form-control'])}}
										<span class="help-block">Decimal Percentage</span>
									</div>
								</div>

								<div class="form-group">
									<label for="discount" class="col-sm-3 control-label">Default</label>
									<div class="col-sm-9">
										{{Form::checkbox('is_default', '1', true, array('class' => 'form control rate_is_default'))}}										
									</div>
								</div>

								<h3>Base Rates</h3>
								<div id="base_rates" class="form-group">
									<label for="base_rates" class="col-sm-3 control-label">Max Mileage / Rate</label>
									<div class="col-sm-4">
										<input type="text" name="base_rate_mileage[]" value="{{old('base_rate_mileage')[0]}}" class="form-control" />
									</div>
									<div class="col-sm-1 text-center" style="padding-top:6px;">
										<b>/</b>
									</div>
									<div class="col-sm-4">
										<input type="text" name="base_rate_value[]" value="{{old('base_rate_value')[0]}}" class="form-control" />
									</div>
								</div>
								@for($i=1; $i<count(old('base_rate_mileage')); $i++)
								<div class="form-group baseRateRow">
									<div class="col-sm-4 col-sm-offset-3">
										<input type="text" name="base_rate_mileage[]" value="{{old('base_rate_mileage')[$i]}}" class="form-control" />
									</div>
									<div class="col-sm-1 text-center" style="padding-top:6px;">
										<b>/</b>
									</div>
									<div class="col-sm-4">
										<input type="text" name="base_rate_value[]" value="{{old('base_rate_value')[$i]}}" class="form-control" />
									</div>
								</div>
								@endfor
								<div class="form-group">
									<div class="col-sm-6 col-sm-offset-3">
										<button id="addRow" class="btn btn-default">Add Base Rate Row</button>
										<button id="removeRow" class="btn btn-default">Remove Base Rate Row</button>
									</div>
									<div class="col-sm-12">
										{{Form::submit('Create Rate', ['id'=>'submit-rate', 'class'=>'btn btn-primary pull-right'])}}
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