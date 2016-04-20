@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.billing.show', $rate->billing_office_id)}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to {{$rate->billing_office->name}}</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.rates.index')}}">Rates</a></li>
						<li class="active">{{$rate->name}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">{{$rate->name}}</h3>
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Rate</a>
					<a href="{{route('admin.rates.edit', ['id'=>$rate->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Rate</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Rate Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Nickname</strong></div>
										<div class="col-sm-8">
											<?php setlocale(LC_MONETARY, 'en_US'); ?>
											{{$rate->name}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Billing Office</strong></div>
										<div class="col-sm-8">
											{{$rate->billing_office->name}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Chain Up Fee</strong></div>
										<div class="col-sm-8">
											{{-- {{money_format('%n', $rate->chain_up_fee)}} --}}
											{{$rate->chain_up_fee}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Chain Up Driver Pay</strong></div>
										<div class="col-sm-8">
											{{-- money_format('%n', $rate->chain_up_pay)--}}
											{{$rate->chain_up_pay}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Demurrage Fee</strong></div>
										<div class="col-sm-8">
											{{-- money_format('%n', $rate->demm_fee) --}}
											{{$rate->demm_fee}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>No Charge Demurrage Hrs</strong></div>
										<div class="col-sm-8">
											{{$rate->nc_demm_hrs}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Divert Fee</strong></div>
										<div class="col-sm-8">
											{{-- money_format('%n', $rate->divert_fee) --}}
											{{$rate->divert_fee}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Reject Fee</strong></div>
										<div class="col-sm-8">
											{{-- money_format('%n', $rate->reject_fee) --}}
										     {{$rate->reject_fee}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Split Fee</strong></div>
										<div class="col-sm-8">
											{{-- money_format('%n', $rate->split_fee) --}}
											{{ $rate->split_fee}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Divert Fee</strong></div>
										<div class="col-sm-8">
											{{-- money_format('%n', $rate->divert_fee) --}}
											{{ $rate->divert_fee  }}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Masking Fee</strong></div>
										<div class="col-sm-8">
											{{-- money_format('%n', $rate->masking_fee) --}}
											{{$rate->masking_fee}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Fuel Surcharge Formula</strong></div>
										<div class="col-sm-8">
											{{$rate->fsc_formula}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Load Barrels</strong></div>
										<div class="col-sm-8">
											{{$rate->load_barrels}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Load Time</strong></div>
										<div class="col-sm-8">
											{{$rate->load_time}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Minimum Barrels</strong></div>
										<div class="col-sm-8">
											{{$rate->min_bbls}}
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Discount</strong></div>
										<div class="col-sm-8">
											{{$rate->discount}}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop