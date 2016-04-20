@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">All Customers <a href="{{route('admin.customers.create')}}" class="btn btn-info" style="margin-left:10px;"><i class="fa fa-plus"></i> Add</a></h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li class="active">Customers</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Customers</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center">Actions</th>
										<th>Name</th>
										<th>Abbreviation</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Address</th>
									</tr>
								</thead>
								<tbody>
									@foreach($customers as $customer)
										<tr class="clickable-row" data-href="{{route('admin.customers.show', ['id'=>$customer->id])}}">
											<td class="text-center actions">
												<a href="{{route('admin.customers.show', ['id'=>$customer->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="#" title="Delete" class="text-danger"><i class="fa fa-trash"></i></a>
											</td>
											<td>{{$customer->name}}</td>
											<td>{{$customer->abbreviation}}</td>
											<td>{{$customer->email}}</td>
											<td>{{$customer->phone}}</td>
											<td>@if(!empty($customer->city)) {{$customer->city.', '}}@endif {{$customer->state.' '.$customer->zip_code}}</td>
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