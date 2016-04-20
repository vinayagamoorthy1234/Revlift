@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">All Operators <a href="{{route('admin.operators.create')}}" class="btn btn-info" style="margin-left:10px;"><i class="fa fa-plus"></i> Add</a></h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li class="active">Operators</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Operators</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th width="10%" class="text-center">Actions</th>
										<th>Name</th>
										<th width="15%">Marketing Company</th>
										<th width="15%">Created At</th>
										<th width="15%">Last Modified</th>
									</tr>
								</thead>
								<tbody>
									@foreach($operators as $operator)
										<tr class="clickable-row" data-href="{{route('admin.operators.show', ['id'=>$operator->id])}}">
											<td class="text-center actions">
												<a href="{{route('admin.operators.show', ['id'=>$operator->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="#" title="Delete" class="text-danger"><i class="fa fa-trash"></i></a>
											</td>
											<td>{{$operator->name}}</td>
											<td><a href="{{route('admin.customers.show', ['id'=>$operator->customer->id])}}" title="View" class="text-primary">{{$operator->customer->abbreviation}}</a></td>
											<td>{{date('m/d/Y', strtotime($operator->created_at))}}</td>
											<td>{{date('m/d/Y', strtotime($operator->updated_at))}}</td>
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