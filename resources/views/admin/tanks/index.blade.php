@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">All Tanks <a href="{{route('admin.tanks.create')}}" class="btn btn-info" style="margin-left:10px;"><i class="fa fa-plus"></i> Add</a></h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li class="active">Tanks</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Tanks</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th width="10%" class="text-center">Actions</th>
										<th>Lease Name</th>
										<th>Tank Number</th>
										<th>Size</th>
										<th width="15%">Created At</th>
										<th width="15%">Last Modified</th>
									</tr>
								</thead>
								<tbody>
									<div style="display:none" id="token" data-token="{{csrf_token()}}"></div>
									@foreach($tanks as $tank)
										<tr class="clickable-row" data-href="{{route('admin.tanks.show', ['id'=>$tank->id])}}">
											<td class="text-center actions">
												<a href="{{route('admin.tanks.show', ['id'=>$tank->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="javascript:;" title="Delete" class="sa-warning text-danger" data-tank-id="{{$tank->id}}"><i class="fa fa-trash"></i></a>
											</td>
											<td>{{$tank->lease->name}} ({{$tank->lease->number}})</td>
											<td>{{$tank->number}}</td>
											<td>{{$tank->size}}</td>
											<td>{{date('m/d/Y', strtotime($tank->created_at))}}</td>
											<td>{{date('m/d/Y', strtotime($tank->updated_at))}}</td>
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