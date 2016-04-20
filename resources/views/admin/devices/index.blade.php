@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">{{$currentUser->account->name}} Devices <a href="{{route('admin.devices.create')}}" class="btn btn-info" style="margin-left:10px;"><i class="fa fa-plus"></i> Add</a></h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li class="active">Devices</li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Devices</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th width="10%" class="text-center">Actions</th>
										<th>Truck</th>
										<th>Tag</th>
										<th>Serial</th>
										<th width="10%" class="text-center">Type</th>
										<th width="15%" class="text-right">Last Modified</th>
									</tr>
								</thead>
								<tbody>
									@foreach($devices as $device)
										<tr class="clickable-row" data-href="{{route('admin.devices.show', ['id'=>$device->id])}}">
											<td class="text-center actions">
												<a href="{{route('admin.devices.show', ['id'=>$device->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="#" title="Delete" class="text-danger"><i class="fa fa-trash"></i></a>
											</td>
											<td>{{$device->truck->truck_number}}</td>
											<td>{{$device->tag_number}}</td>
											<td>{{$device->serial}}</td>
											<td class="text-center">{{$device->type}}</td>
											<td class="text-right">{{date('m/d/Y g:i a', strtotime($device->updated_at))}}</td>
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
