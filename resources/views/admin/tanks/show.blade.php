@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.tanks.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Tanks</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.tanks.index')}}">Tanks</a></li>
						<li class="active">Tank #{{$tank->number}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">Tank #{{$tank->number}}</h3>
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Tank</a>
					<a href="{{route('admin.tanks.edit', ['id'=>$tank->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Tank</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Tank Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Tank Number</strong></div>
								<div class="col-sm-9">
									{{$tank->number}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Lease</strong></div>
								<div class="col-sm-9">
									{{$tank->lease->name}} ({{$tank->lease->number}})
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>BBLs Per Inch</strong></div>
								<div class="col-sm-9">
									{{$tank->bbls_per_inch}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Size</strong></div>
								<div class="col-sm-9">
									{{$tank->size}}
								</div>
							</div>
						</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Tank Strappings</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-hover table-bordered">
								<thead>
									<th class="text-center">Actions</th>
									<th>Qtr Inch</th>
									<th>Rate</th>
									<th>Rate Above</th>
									<th>Cumulative BBLs</th>
								</thead>
								<tbody>
									@foreach($tank->strappings as $strapping)
									<tr class="clickable-row" data-href="{{route('admin.strappings.show', ['id'=>$strapping->id])}}">
										<td class="text-center">
											<a href="{{route('admin.strappings.show', ['id'=>$strapping->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
											<a href="javascript:;" title="Delete" class="sa-warning strapping text-danger" data-strapping-id="{{$strapping->id}}"><i class="fa fa-trash"></i></a>
										</td>
										<td>{{$strapping->qtr}}</td>
										<td>{{$strapping->rate}}</td>
										<td>{{$strapping->rateAbove}}</td>
										<td>{{$strapping->cumulative_bbls}}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop