@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">All Accounts <a href="{{route('admin.accounts.create')}}" class="btn btn-info" style="margin-left:10px;"><i class="fa fa-plus"></i> Add</a></h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li class="active">Accounts</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Accounts</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center">Actions</th>
										<th>Name</th>
										<th>Owner</th>
										<th>Contact</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Address</th>
									</tr>
								</thead>
								<tbody>
									@foreach($accounts as $account)
										<tr class="clickable-row" data-href="{{route('admin.accounts.show', ['id'=>$account->id])}}">
											<td class="text-center actions">
												<a href="{{route('admin.accounts.show', ['id'=>$account->id])}}" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="#" title="Delete" class="text-danger"><i class="fa fa-trash"></i></a>
											</td>
											<td>{{$account->name}}</td>
											<td>{{$account->owner}}</td>
											<td>{{$account->contact_name}}</td>
											<td>{{$account->contact_email}}</td>
											<td>{{$account->contact_phone}}</td>
											<td>@if(!empty($account->city)) {{$account->city.', '}}@endif {{$account->state.' '.$account->zip_code}}</td>
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