@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.strappings.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Strappings</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.strappings.index')}}">Strappings</a></li>
						<li class="active">Strapping for Tank #{{$strapping->tank->number}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">Strapping for Tank #{{$strapping->tank->number}}</h3>
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Strapping</a>
					<a href="{{route('admin.strappings.edit', ['id'=>$strapping->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Strapping</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Strapping Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Tank Number</strong></div>
								<div class="col-sm-9">
									{{$strapping->tank->number}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Qtr Inch</strong></div>
								<div class="col-sm-9">
									{{$strapping->qtr}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Rate</strong></div>
								<div class="col-sm-9">
									{{$strapping->rate}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Rate Above</strong></div>
								<div class="col-sm-9">
									{{$strapping->rateAbove}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Cumulative BBLs</strong></div>
								<div class="col-sm-9">
									{{$strapping->cumulative_bbls}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Strapping Source</strong></div>
								<div class="col-sm-9">
									{{$strapping->source}}
								</div>
							</div>
						</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop