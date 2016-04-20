@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Add New Rate</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.rates.index')}}">Rates</a></li>
						<li class="active">New</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Rate Info</h4>
						</div>
						<div class="panel-body">
							@include('errors.form')
							<form method="POST" action="{{route('admin.rates.store')}}" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="name" class="col-sm-3 control-label">Nickname</label>
									<div class="col-sm-9">
										{{Form::text('name', '', ['id'=>'name', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="billing_office" class="col-sm-3 control-label">Billing Office</label>
									<div class="col-sm-9">
										<?php
											$data = App\BillingOffice::leftJoin('customers', 'billing_offices.customer_id', '=', 'customers.id')->where('customers.account_id', $currentUser->account->id)->select('billing_offices.*')->get();
											$list = [];
											foreach($data as $billing_office) {
												$list[$billing_office->id] = $billing_office->name;
											}
										?>
										{{Form::select('billing_office', $list, '', ['id'=>'billing_office', 'class'=>'form-control'])}}
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
									<label for="fsc" class="col-sm-3 control-label">Fuel Surcharge</label>
									<div class="col-sm-9">
										{{Form::text('fsc', '', ['id'=>'fsc', 'class'=>'form-control'])}}
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
									<label for="min_bbls" class="col-sm-3 control-label">Minimum Barrels</label>
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
									<div class="col-sm-3">
										{{Form::submit('Create Rate', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
									</div>
								</div>
							</form>
						</div>
					</div>
				</div> <!-- end col -->
			</div>

		</div> <!-- container -->
	</div> <!-- content -->
@stop