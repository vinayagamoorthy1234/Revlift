@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Add New Shipment</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.shipments.index')}}">Shipments</a></li>
						<li class="active">New</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Shipment Info</h4>
						</div>
						<div class="panel-body">
							@include('errors.form')
							<form method="POST" action="{{route('admin.shipments.store')}}" class="form-horizontal">
								<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
								<div class="col-md-6" style="border-right:1px solid #EEE;">
									<div class="form-group col-sm-6">
										<label for="ticket_number" class="col-sm-4 control-label">Ticket #</label>
										<div class="col-sm-8">
											{{Form::text('ticket_number', '', ['id'=>'ticket_number', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="ticket_date" class="col-sm-4 control-label">Date</label>
										<div class="col-sm-8">
											{{Form::text('ticket_date', date('m/d/Y', strtotime('now')), ['id'=>'ticket_date', 'class'=>'form-control datepicker'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="lease_id" class="col-sm-4 control-label">Lease</label>
										<div class="col-sm-8">
											<?php
												$data = App\Lease::leftJoin('operators', 'leases.operator_id', '=', 'operators.id')
													->leftJoin('customers', 'operators.customer_id', '=', 'customers.id')
													->where('customers.account_id', $currentUser->account->id)
													->select('leases.*')->orderBy('leases.name', 'asc')->get();

												$leaseData = [];
												for($i=0;$i<count($data);$i++) {
													$leaseData[$i]['id'] = $data[$i]->id;
													$leaseData[$i]['name'] = $data[$i]->name.' ('.$data[$i]->number.')';
												}

												$leaseList = ['' => 'Please Select'];
												foreach($leaseData as $lease) {
													$leaseList[$lease['id']] = $lease['name'];
												}

											?>
											{{Form::select('lease_id', $leaseList, '', ['id'=>'lease_id', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="tank_id" class="col-sm-4 control-label">Tank</label>
										<div class="col-sm-8">
											{{Form::select('tank_id', ['' => 'Select a Lease'], '', ['readonly'=>'readonly', 'id'=>'tank_id', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="display_lease_id" class="col-sm-4 control-label">Lease #</label>
										<div class="col-sm-8">
											{{Form::text('display_lease_id', 'Select A Lease', ['readonly'=>'readonly', 'id'=>'display_lease_id', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="operator" class="col-sm-4 control-label">Operator</label>
										<div class="col-sm-8">
											<input type="hidden" name="operator_id" id="operator_id" value="0" />
											{{Form::text('operator', 'Select A Lease', ['readonly'=>'readonly', 'id'=>'operator', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="driver_id" class="col-sm-4 control-label">Driver</label>
										<div class="col-sm-8">
											<?php
												$data = App\Driver::where('account_id', $currentUser->account->id)->get();

												$drivers = [];
												for($i=0;$i<count($data);$i++) {
													$drivers[$i]['id'] = $data[$i]->id;
													$drivers[$i]['name'] = $data[$i]->firstname.' '.$data[$i]->lastname;
												}

												$driverList = ['' => 'Please Select'];
												foreach($drivers as $driver) {
													$driverList[$driver['id']] = $driver['name'];
												}

											?>
											{{Form::select('driver_id', $driverList, '', ['id'=>'driver_id', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="truck_id" class="col-sm-4 control-label">Truck</label>
										<div class="col-sm-8">
											<?php
												$data = App\Truck::where('account_id', $currentUser->account->id)->orderBy('truck_number', 'asc')->get();

												$trucks = [];
												for($i=0;$i<count($data);$i++) {
													$trucks[$i]['id'] = $data[$i]->id;
													$trucks[$i]['number'] = $data[$i]->truck_number;
												}

												$truckList = ['' => 'Please Select'];
												foreach($trucks as $truck) {
													$truckList[$truck['id']] = $truck['number'];
												}

											?>
											{{Form::select('truck_id', $truckList, '', ['id'=>'truck_id', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="trailer_id" class="col-sm-4 control-label">Trailer</label>
										<div class="col-sm-8">
											<?php
												$data = App\Trailer::where('account_id', $currentUser->account->id)->orderBy('trailer_number', 'asc')->get();

												$trailers = [];
												for($i=0;$i<count($data);$i++) {
													$trailers[$i]['id'] = $data[$i]->id;
													$trailers[$i]['number'] = $data[$i]->trailer_number;
												}

												$trailersList = ['' => 'Please Select'];
												foreach($trailers as $trailer) {
													$trailersList[$trailer['id']] = $trailer['number'];
												}

											?>
											{{Form::select('trailer_id', $trailersList, '', ['id'=>'trailer_id', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="rate_id" class="col-sm-4 control-label">Rate Class</label>
										<div class="col-sm-8">
											{{Form::select('rate_id', ['' => 'Select a Lease'], '', ['readonly'=>'readonly', 'id'=>'rate_id', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-12">
										<label for="tmw_or_fob" class="col-sm-2 control-label">TMW/FOB</label>
										<div class="col-sm-10">
											<div class="radio radio-info radio-inline">
												{{Form::radio('tmw_or_fob', 'Neither', 'checked', ['id'=>'tmw_or_fob', 'class'=>'form-control'])}}
												<label>Neither</label>
											</div>
											<div class="radio radio-info radio-inline">
												{{Form::radio('tmw_or_fob', 'TMW', '', ['class'=>'form-control'])}}
												<label>TMW</label>
											</div>
											<div class="radio radio-info radio-inline">
												{{Form::radio('tmw_or_fob', 'FOB', '', ['class'=>'form-control'])}}
												<label>FOB</label>
											</div>
										</div>
									</div>
									<div class="col-xs-12">
										<hr style="margin:5px 0;" />
										<h3>Oil Level</h3>
									</div>
									<table class="table table-bordered">
										<thead>
											<th style="border:0;"></th>
											<th>Feet</th>
											<th>Inches</th>
											<th>Quarters</th>
											<th>Temp</th>
											<th>Barrels</th>
										</thead>
										<tbody>
											<tr>
												<th>Top</th>
												<td>{{Form::text('top_feet', '', ['id'=>'top_feet', 'placeholder'=>'', 'class'=>'form-control'])}}</td>
												<td>{{Form::text('top_inches', '', ['id'=>'top_inches', 'placeholder'=>'', 'class'=>'form-control'])}}</td>
												<td>{{Form::text('top_qtr_inches', '', ['id'=>'top_qtr_inches', 'placeholder'=>'', 'class'=>'form-control'])}}</td>
												<td>{{Form::text('top_temp', '', ['id'=>'top_temp', 'placeholder'=>'', 'class'=>'form-control'])}}</td>
												<td><span id="bbls_top"></span></td>
											</tr>
											<tr>
												<th>Bottom</th>
												<td>{{Form::text('bot_feet', '', ['id'=>'bot_feet', 'placeholder'=>'', 'class'=>'form-control'])}}</td>
												<td>{{Form::text('bot_inches', '', ['id'=>'bot_inches', 'placeholder'=>'', 'class'=>'form-control'])}}</td>
												<td>{{Form::text('bot_qtr_inches', '', ['id'=>'bot_qtr_inches', 'placeholder'=>'', 'class'=>'form-control'])}}</td>
												<td>{{Form::text('bot_temp', '', ['id'=>'bot_temp', 'placeholder'=>'', 'class'=>'form-control'])}}</td>
												<td><span id="bbls_bot"></span></td>
											</tr>
										</tbody>
									</table>
									<div class="form-group col-sm-6">
										<label for="bsw" class="col-sm-4 control-label">BS&amp;W</label>
										<div class="col-sm-8">
											{{Form::text('bsw', '', ['id'=>'bsw', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="gross_bbl_strapping_calc" class="col-sm-4 control-label">Total BBls</label>
										<div class="col-sm-8">
											{{Form::text('gross_bbl_strapping_calc', '', ['readonly'=>'readonly', 'id'=>'gross_bbl_strapping_calc', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="obs_temp" class="col-sm-4 control-label">Obs Temp</label>
										<div class="col-sm-8">
											{{Form::text('obs_temp', '', ['id'=>'obs_temp', 'placeholder'=>'', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="obs_gravity" class="col-sm-4 control-label">Obs Gravity</label>
										<div class="col-sm-8">
											{{Form::text('obs_gravity', '', ['id'=>'obs_gravity', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="avg_temp" class="col-sm-4 control-label">Avg Temp &deg;F</label>
										<div class="col-sm-8">
											{{Form::text('avg_temp', '', ['id'=>'avg_temp', 'readonly'=>'readonly', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="gravity_calc" class="col-sm-4 control-label">Gravity @ 60&deg;F</label>
										<div class="col-sm-8">
											{{Form::text('gravity_calc', '', ['id'=>'gravity_calc', 'readonly'=>'readonly', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="col-xs-12">
										<hr style="margin:0 0 12px;" />
									</div>
									<div class="form-group col-sm-12">
										<label for="lease_time_on" class="col-sm-3 control-label">Lease Time On</label>
										<div class="col-sm-9">
											{{Form::text('lease_time_on', '', ['id'=>'lease_time_on', 'placeholder'=>'9:00 AM', 'class'=>'form-control timepicker'])}}
										</div>
									</div>
									<div class="form-group col-sm-12">
										<label for="lease_time_off" class="col-sm-3 control-label">Lease Time Off</label>
										<div class="col-sm-9">
											{{Form::text('lease_time_off', '', ['id'=>'lease_time_off', 'placeholder'=>'10:00 AM', 'class'=>'form-control timepicker'])}}
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="depot_id" class="col-sm-3 control-label">Depot</label>
										<div class="col-sm-9">
											<?php
												$data = App\Depot::where('account_id', $currentUser->account->id)->get();

												$depotData = [];
												for($i=0;$i<count($data);$i++) {
													$depotData[$i]['id'] = $data[$i]->id;
													$depotData[$i]['name'] = $data[$i]->name.' ('.$data[$i]->code.')';
												}

												$depotList = ['' => 'Please Select'];
												foreach($depotData as $depot) {
													$depotList[$depot['id']] = $depot['name'];
												}

											?>
											{{Form::select('depot_id', $depotList, '', ['id'=>'depot_id', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label for="header_id" class="col-sm-3 control-label">Depot Header</label>
										<div class="col-sm-9">
											{{Form::select('header_id', ['' => 'Select a Depot First'], '', ['readonly'=>'readonly', 'id'=>'header_id', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="depot_time_on" class="col-sm-6 control-label">Depot Time On</label>
										<div class="col-sm-6">
											{{Form::text('depot_time_on', '', ['id'=>'depot_time_on', 'placeholder'=>'9:00 AM', 'class'=>'form-control timepicker'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="depot_time_off" class="col-sm-6 control-label">Depot Time Off</label>
										<div class="col-sm-6">
											{{Form::text('depot_time_off', '', ['id'=>'depot_time_off', 'placeholder'=>'10:00 AM', 'class'=>'form-control timepicker'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="demm_hrs" class="col-sm-6 control-label">Demmurage Hours</label>
										<div class="col-sm-6">
											{{Form::text('demm_hrs', '', ['id'=>'demm_hrs', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="demm_reason" class="col-sm-6 control-label">Demmurage Reason</label>
										<div class="col-sm-6">
											{{Form::text('demm_reason', '', ['id'=>'demm_reason', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="divert_hrs" class="col-sm-6 control-label">Divert Hours</label>
										<div class="col-sm-6">
											{{Form::text('divert_hrs', '', ['id'=>'divert_hrs', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group col-sm-6">
										<label for="demm_reason" class="col-sm-6 control-label">Divert Reason</label>
										<div class="col-sm-6">
											{{Form::text('divert_reason', '', ['id'=>'divert_reason', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label for="chain_up" class="col-sm-3 control-label">Chain Up</label>
										<div class="checkbox checkbox-info col-sm-9">
											<input id="chain_up" type="checkbox" class="form-control">
											<label for="chain_up">&nbsp;</label>
										</div>
									</div>
									<div class="form-group">
										<label for="masking_up" class="col-sm-3 control-label">Mask Up</label>
										<div class="checkbox checkbox-info col-sm-9">
											<input id="masking_up" type="checkbox" class="form-control">
											<label for="masking_up">&nbsp;</label>
										</div>
									</div>
									<div class="form-group">
										<label for="split_load" class="col-sm-3 control-label">Split Load</label>
										<div class="checkbox checkbox-info col-sm-9">
											<input id="split_load" type="checkbox" class="form-control">
											<label for="split_load">&nbsp;</label>
										</div>
									</div>
									<div class="form-group">
										<label for="reject_load" class="col-sm-3 control-label">Rejected Load</label>
										<div class="checkbox checkbox-danger col-sm-9">
											<input id="reject_load" type="checkbox" class="form-control">
											<label for="reject_load">&nbsp;</label>
										</div>
									</div>
									<div class="form-group">
										<label for="notes" class="col-sm-3 control-label">Notes</label>
										<div class="col-sm-9">
											{{Form::textarea('notes', '', ['rows'=>'5', 'id'=>'notes', 'class'=>'form-control'])}}
										</div>
									</div>
									<br />
									{{--<div class="form-group">
										<label for="a_value" class="col-sm-3 control-label">A Value</label>
										<div class="col-sm-9">--}}
											{{Form::hidden('a_value', '', ['id'=>'a_value', 'readonly'=>'readonly', 'class'=>'form-control'])}}
										{{--</div>
									</div>
									<div class="form-group">
										<label for="ctl_top" class="col-sm-3 control-label">CTL Top</label>
										<div class="col-sm-9"> --}}
											{{Form::hidden('ctl_top', '', ['id'=>'ctl_top', 'readonly'=>'readonly', 'class'=>'form-control'])}}
										{{--</div>
									</div>
									<div class="form-group">
										<label for="ctl_bot" class="col-sm-3 control-label">CTL Bottom</label>
										<div class="col-sm-9">--}}
											{{Form::hidden('ctl_bot', '', ['id'=>'ctl_bot', 'readonly'=>'readonly', 'class'=>'form-control'])}}
										{{--</div>
									</div>--}}
									<div class="form-group">
										<label for="net_bbl" class="col-sm-3 control-label">Net BBLs</label>
										<div class="col-sm-9">
											{{Form::text('net_bbl', '', ['id'=>'net_bbl', 'readonly'=>'readonly', 'class'=>'form-control'])}}
										</div>
									</div>
									<br />
									<div class="form-group">
										<label for="mileage" class="col-sm-3 control-label">Distance (Mi)</label>
										<div class="col-sm-9">
											{{Form::text('mileage', '', ['id'=>'mileage', 'readonly'=>'readonly', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label for="fsc" class="col-sm-3 control-label">Fuel Surcharge</label>
										<div class="col-sm-9">
											{{Form::text('fsc', '', ['readonly'=>'readonly', 'id'=>'fsc', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label for="bbls_charge" class="col-sm-3 control-label">Barrels Charge</label>
										<div class="col-sm-9">
											{{Form::text('bbls_charge', '', ['id'=>'bbls_charge', 'readonly'=>'readonly', 'class'=>'form-control'])}}
										</div>
									</div>
									<div class="form-group">
										<label for="cust_bbls_charge" class="col-sm-3 control-label">Customer Barrels Charge</label>
										<div class="col-sm-9">
											{{Form::text('cust_bbls_charge', '', ['id'=>'cust_bbls_charge', 'readonly'=>'readonly', 'class'=>'form-control'])}}
										</div>
									</div>
								</div>
								<div class="col-xs-12">
									<hr />
									<div class="form-group">
										<div class="col-sm-12">
											{{Form::submit('Create Shipment', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div> <!-- end col -->
			</div>

		</div> <!-- container -->
	</div> <!-- content -->

	<script>
		$('.datepicker').datepicker({
			autoclose: true,
			todayHighlight: true
		});

		$.ajaxSetup({
			headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() }
		});

		$('#obs_temp, #top_temp, #bot_temp').change(function(e) {
			var top_temp = $('#top_temp').val();
			var bot_temp = $('#bot_temp').val();
			var obs_temp = $('#obs_temp').val();

			if(top_temp!=='' && bot_temp!=='' && obs_temp!=='') {
				var sum = parseFloat(top_temp) + parseFloat(bot_temp) + parseFloat(obs_temp);
				var avg = sum/3;
				$('#avg_temp').val(parseFloat(avg).toFixed(1));
			} else {
				$('#avg_temp').val('');
			}
		});

		// Run the calculation for the Gravity at 60 degrees and the A value
		$('#obs_gravity').change(function(e) {
			var obs_gravity = $('#obs_gravity').val();
			var avg_temp = $('#avg_temp').val();

			if(avg_temp!=='' && obs_gravity!=='') {
				// Gravity Calculation first
				var top = parseFloat(obs_gravity) - 0.059175 * (parseFloat(avg_temp) - 60);
				console.log(top);
				var bot = 1 + 0.00045 * (parseFloat(avg_temp) - 60);
				console.log(bot);
				var gravity = top/bot;
				$('#gravity_calc').val(parseFloat(gravity).toFixed(2));

				var gravity_calc = $('#gravity_calc').val();
				var aValue = (0.00000008235*(Math.pow(parseFloat(gravity_calc),2))+0.000000304845*parseFloat(gravity_calc)+0.0003625245);
				console.log(aValue);
				$('#a_value').val(parseFloat(aValue).toFixed(5));
			} else {
				$('#gravity_calc').val('');
				$('#a_value').val('');
			}
		});

		// Run the calculation for the CTL Top
		$('#obs_gravity, #top_temp').change(function(e) {
			var aValue = $('#a_value').val();
			var top_temp = $('#top_temp').val();

			if(top_temp!=='' && aValue!=='') {
				var ctl_top = Math.exp(-parseFloat(aValue)*(parseFloat(top_temp)-60)*(1+0.8*parseFloat(aValue)*(parseFloat(top_temp)-60)));
				console.log(ctl_top);
				$('#ctl_top').val(parseFloat(ctl_top).toFixed(4));
			} else {
				$('#ctl_top').val('');
			}
		});

		// Run the calculation for the CTL Bottom
		$('#obs_gravity, #bot_temp').change(function(e) {
			var aValue = $('#a_value').val();
			var bot_temp = $('#bot_temp').val();

			if(bot_temp!=='' && aValue!=='') {
				var ctl_bot = Math.exp(-parseFloat(aValue)*(parseFloat(bot_temp)-60)*(1+0.8*parseFloat(aValue)*(parseFloat(bot_temp)-60)));
				console.log(ctl_bot);
				$('#ctl_bot').val(parseFloat(ctl_bot).toFixed(4));
			} else {
				$('#ctl_bot').val('');
			}
		});

		// Run the calculation for the Net BBLs
		$('#top_feet, #top_inches, #top_qtr_inches, #bot_feet, #bot_inches, #bot_qtr_inches, #bsw').change(function(e) {
			var top_feet = $('#top_feet').val();
			var top_inches = $('#top_inches').val();
			var top_qtr_inches = $('#top_qtr_inches').val();
			var bot_feet = $('#bot_feet').val();
			var bot_inches = $('#bot_inches').val();
			var bot_qtr_inches = $('#bot_qtr_inches').val();
			var ctl_top = $('#ctl_top').val();
			var ctl_bot = $('#ctl_bot').val();
			var bsw = $('#bsw').val();

			if(top_feet!=='' && top_inches!=='' && top_qtr_inches!=='' && bot_feet!=='' && bot_inches!=='' && bot_qtr_inches!=='' && ctl_top!=='' && ctl_bot!=='' && bsw!=='') {
				var net_bbl = (((parseFloat(top_feet)*12+parseFloat(top_inches)+parseFloat(top_qtr_inches)/4)*1.67*parseFloat(ctl_top))-((parseFloat(bot_feet)*12+parseFloat(bot_inches)+parseFloat(bot_qtr_inches)/4)*1.67*parseFloat(ctl_bot)))*(1-parseFloat(bsw)/100);
				console.log(net_bbl);
				$('#net_bbl').val(parseFloat(net_bbl).toFixed(2));
			} else {
				$('#net_bbl').val('');
			}
		});


		// BBL Strapping Calculation
		$('#top_feet, #top_inches, #top_qtr_inches, #bot_feet, #bot_inches, #bot_qtr_inches').change(function(event) {
			var top_feet = $('#top_feet').val();
			var top_inches = $('#top_inches').val();
			var top_qtr_inches = $('#top_qtr_inches').val();
			var bot_feet = $('#bot_feet').val();
			var bot_inches = $('#bot_inches').val();
			var bot_qtr_inches = $('#bot_qtr_inches').val();

			if(top_feet!=='' && top_inches!=='' && top_qtr_inches!=='' && bot_feet!=='' && bot_inches!=='' && bot_qtr_inches!=='') {
				var top = (parseFloat(top_feet)*12+parseFloat(top_inches)+parseFloat(top_qtr_inches)/4)*1.67;
				$('#bbls_top').text(parseFloat(top).toFixed(2));
				var bot = (parseFloat(bot_feet)*12+parseFloat(bot_inches)+parseFloat(bot_qtr_inches)/4)*1.67;
				$('#bbls_bot').text(parseFloat(bot).toFixed(2));
				var formula = top-bot;
				console.log(formula);
				$('#gross_bbl_strapping_calc').val(parseFloat(formula).toFixed(2));
			}
		});

		// Get the Rates, Operators, and Tanks when the lease ID is changed
		$('#lease_id').change(function(e) {
			var params = {};
			params['lease_id'] = $(this).val();

			$('#display_lease_id').val($('#lease_id option:selected').text().split('(')[1].split(')')[0]);

			// console.log(params);

			$.post('/admin/shipments/ajax', params, function(data, textStatus, xhr) {
				// Get Rates and Tanks
				// console.log(data);
				if(data.rates=='No Rates') {
					$('#rate_id option').remove();
					$('#rate_id').append($('<option></option>').attr("value",'0').text('No Rates Found'));
				} else {
					$('#rate_id option').remove();
					$('#rate_id').append($('<option></option>').attr("value",'').text('Select A Rate'));
					$.each(data.rates, function(key, value) {
						$('#rate_id').append($('<option></option>').attr("value",value.id).text(value.name));
					});
					$('#rate_id').prop('disabled', false);
					$('#rate_id option:first').text('Select A Rate');
				}

				if(data.operator == 'No Operator') {
					$('#operator_id').val('0');
					$('#operator').val('No Operator');
				} else {
					$('#operator_id').val(data.operator.id);
					$('#operator').val(data.operator.name);
				}

				if(data.tanks=='No Tanks') {
					$('#tank_id option').remove();
					$('#tank_id').append($('<option></option>').attr("value",'0').text('No Tanks Found'));
				} else {
					$('#tank_id option').remove();
					$('#tank_id').append($('<option></option>').attr("value",'').text('Select A Tank'));
					$.each(data.tanks, function(key, value) {
						$('#tank_id').append($('<option></option>').attr("value",value.id).text(value.number));
					});
					$('#tank_id').prop('disabled', false);
					$('#tank_id option:first').text('Select A Tank');
				}
			});
		});

		// Get the Headers when the depot is changed
		$('#depot_id').change(function(e) {
			var params = {};
			params['depot_id'] = $(this).val();

			// console.log(params);

			$.post('/admin/shipments/ajax', params, function(data, textStatus, xhr) {
				// Get headers
				console.log(data);
				if(data=='No Headers') {
					$('#header_id option').remove();
					$('#header_id').append($('<option></option>').attr("value",'0').text('No Headers Found'));
				} else {
					$('#header_id option').remove();
					$('#header_id').prop('disabled', false);
					$('#header_id').append($('<option></option>').attr("value",'').text("Select A Header"));
					$.each(data, function(key, value) {
						$('#header_id').append($('<option></option>').attr("value",value.id).text(value.name));
					});
				}
			});
		});

		// Get the mileage (distance) when Depot and Lease are selected.
		$('#depot_id, #lease_id').change(function(e) {
			var params = {};
			params['depot_id'] = $('#depot_id').val();
			params['lease_id'] = $('#lease_id').val();

			console.log(params);

			if($('#depot_id').val()!=='' && $('#lease_id').val()!=='')
			$.post('/admin/shipments/ajax', params, function(data, textStatus, xhr) {
				console.log(data);
				$('#mileage').val(data[0].mileage);
			});
		});

		$('#rate_id').change(function(e) {
			var params = {};
			params['rate_id'] = $('#rate_id').val();

			console.log(params);

			window.return_price = function() {
				var price = 2.00;

				// Get the Diesel price: http://api.eia.gov/series/?api_key=YOUR_API_KEY_HERE&series_id=PET.EMD_EPD2D_PTE_R40_DPG.W
				var api_key = '665EFE27094361EA335CED3E11F0F200';
				
				var settings = {
					"async": true,
					"crossDomain": true,
					"url": "http://api.eia.gov/series/?api_key="+api_key+"&series_id=PET.EMD_EPD2D_PTE_R40_DPG.W",
					"method": "GET",
					"headers": {
						"cache-control": "no-cache"
					}
				}

				$.ajax(settings).success(function(response) {
					console.log(response);
					price = response.series.data[0][1];
				})

				return price;
			}();

			window.base_rate = function() {
				var base_rate = 1.86;
				var mileage = 5;
				
				// $.post('/admin/shipments/ajax', params, function(data, textStatus, xhr) {
					// console.log(data);
					// base_rate = response.series.data[0][1];
				// });

				return base_rate;
			}();

			$.post('/admin/shipments/ajax', params, function(fees, textStatus, xhr) {
				console.log(fees);
				window.chain_up_fee = fees.chain_up_fee;
				window.demm_fee = fees.demm_fee;
				window.discount = fees.discount;
				window.divert_fee = fees.divert_fee;
				window.fsc_formula = fees.fsc_formula;
				window.masking_fee = fees.masking_fee;
				window.min_bbls = fees.min_bbls;
				window.reject_fee = fees.reject_fee;
				window.split_fee = fees.split_fee;

				window.base_rate = 2.24;
				var fsc = fsc_formula.replace('price', return_price);
				fsc = fsc.replace('base_rate', base_rate);
				console.log('formula: '+fsc_formula);
				console.log('with values: '+fsc);
				console.log(eval(fsc));

				if(eval(fsc)<0) {
					console.log('surcharge less than 0');
					$('#fsc').val('0');
				} else {
					$('#fsc').val(eval(fsc));
				}
			});
		});

		// function to calculate charges
		function calculateCharges() {
			if($('#rate_id').val()!=='') {
				var bbls_charge = parseFloat($('#gross_bbl_strapping_calc').val()) * parseFloat(base_rate);
				var customer_charge = parseFloat($('#net_bbl').val()) * parseFloat(base_rate);

				$('#bbls_charge').val(parseFloat(bbls_charge).toFixed(2));
				$('#cust_bbls_charge').val(parseFloat(customer_charge).toFixed(2));
			} else {
				$('#bbls_charge').val('Missing Rate Class');
				$('#cust_bbls_charge').val('Missing Rate Class');
			}
		}

		function handleFee(type, fee) {
			var customer_charge = $('#cust_bbls_charge').val();

			if(type=="add" && fee>0) {
				customer_charge = parseFloat(customer_charge)+parseInt(fee);
			}

			if(type=="subtract" && fee>0) {
				customer_charge = parseFloat(customer_charge)-parseInt(fee);
			}

			$('#cust_bbls_charge').val(parseFloat(customer_charge).toFixed(2));
		}

		// Calculate the Estimated Total Charges
		$('#top_feet, #top_inches, #top_qtr_inches, #bot_feet, #bot_inches, #bot_qtr_inches, #bsw, #rate_id').change(function(e) {
			calculateCharges();
		});

		// If load is rejected, total price is only the reject fee
		$('#reject_load').change(function(e) {			
			if($('#bbls_charge').val()=='90' && $('#cust_bbls_charge').val()=='90') {
				calculateCharges();
			} else {
				$('#bbls_charge').val('90');
				$('#cust_bbls_charge').val('90');
			}
		});

		// If the driver had to chain up, add the chain up fee to the total cost
		$('#chain_up').change(function(e) {			
			if($('#bbls_charge').val()=='90' && $('#cust_bbls_charge').val()=='90') {
				// do nothing
				console.log('load was rejected, cannot charge chain  up fee');
			} else {
				var fee = chain_up_fee;
				if($("#chain_up").is(":checked")) {
					handleFee('add', fee);
				} else {
					handleFee('subtract', fee);
				}
			}
		});

		// If the driver had to chain up, add the chain up fee to the total cost
		$('#masking_up').change(function(e) {			
			if($('#bbls_charge').val()=='90' && $('#cust_bbls_charge').val()=='90') {
				// do nothing
				console.log('load was rejected, cannot charge mask up fee');
			} else {
				var fee = masking_fee;
				if($("#masking_up").is(":checked")) {
					handleFee('add', fee);
				} else {
					handleFee('subtract', fee);
				}
			}
		});

		// if there was a spit load, show the split ticket number field
		$('#split_load').change(function(e) {
			if($('#bbls_charge').val()=='90' && $('#cust_bbls_charge').val()=='90') {
				// do nothing
				console.log('load was rejected, cannot charge split fee');
			} else {
				var fee = split_fee;
				if($("#split_load").is(":checked")) {
					handleFee('add', fee);
				} else {
					handleFee('subtract', fee);
				}
			}
		});

		// if there is waiting time, charge demm_fee
		$('#demm_hrs').blur(function(e) {			
			if($('#bbls_charge').val()=='90' && $('#cust_bbls_charge').val()=='90') {
				// do nothing
				console.log('load was rejected, cannot charge demm fee');
			} else {
				var fee = demm_fee;
				if($("#demm_hrs").val()>0) {
					handleFee('add', fee);
				} else {
					handleFee('subtract', fee);
				}
			}
		});

		// if there is divert time, charge divert_fee
		$('#divert_hrs').blur(function(e) {			
			if($('#bbls_charge').val()=='90' && $('#cust_bbls_charge').val()=='90') {
				// do nothing
				console.log('load was rejected, cannot charge divert fee');
			} else {
				var fee = divert_fee;
				if($("#divert_hrs").val()>0) {
					handleFee('add', fee);
				} else {
					handleFee('subtract', fee);
				}
			}
		});
	</script>
@stop