@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">All Trailers <a href="{{route('admin.trailers.create')}}" class="btn btn-info" style="margin-left:10px;"><i class="fa fa-plus"></i> Add</a></h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li class="active">Trailers</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Trailers</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th width="10%" class="text-center">Actions</th>
										<th>ID</th>
										<th>Owner</th>
										<th>Rate</th>
										<th width="15%">Created At</th>
										<th width="15%">Last Modified</th>
									</tr>
								</thead>
								<tbody>
									@foreach($trailers as $trailer)
										<tr class="clickable-row" data-href="{{route('admin.trailers.show', ['id'=>$trailer->id])}}">
											<td class="text-center actions">
												<a href="{{route('admin.trailers.show', ['id'=>$trailer->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="#" title="Delete" class="text-danger"><i class="fa fa-trash"></i></a>
											</td>
											<td>{{$trailer->trailer_number}}</td>
											<td>{{$trailer->owner}}</td>
											<td>{{$trailer->rate}}</td>
											<td>{{date('m/d/Y', strtotime($trailer->created_at))}}</td>
											<td>{{date('m/d/Y', strtotime($trailer->updated_at))}}</td>
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