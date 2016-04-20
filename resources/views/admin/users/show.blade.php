@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.users.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Users</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.users.index')}}">Users</a></li>
						<li class="active">{{$user->firstname.' '.$user->lastname}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<?php
						if($user->role=='Admin') $color = 'danger';
						elseif($user->role=='Owner') $color = 'warning';
						elseif($user->role=='Manager') $color = 'success';
						else $color = 'purple';
					?>
					<h3 class="pull-left page-title">{{$user->firstname.' '.$user->lastname}} <small class="badge badge-{{$color}}">{{$user->role}}</small></h3>
					<a href="{{route('admin.users.edit', ['id'=>$user->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit user</a>
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete user</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">User Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Company</strong></div>
								<div class="col-sm-9">
									<a href="{{route('admin.accounts.show', ['id'=>$user->account->id])}}">{{$user->account->name}}</a>
								</div>
							</div>
							@if(!empty($user->email))
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Email</strong></div>
								<div class="col-sm-9">
									{{$user->email}}
								</div>
							</div>
							@endif
							@if(!empty($user->phone))
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Phone</strong></div>
								<div class="col-sm-9">
									{{$user->phone}}
								</div>
							</div>
							@endif
							@if(!empty($user->description))
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Description</strong></div>
								<div class="col-sm-9">
									{{$user->description}}
								</div>
							</div>
							@endif
						</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop