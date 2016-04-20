@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Edit User</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.users.index')}}">Users</a></li>
						<li><a href="{{route('admin.users.show', ['id'=>$user->id])}}">{{$user->name}}</a></li>
						<li class="active">Edit</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">User Info</h4>
						</div>
						<div class="panel-body">
							<form method="POST" action="{{route('admin.users.update', ['id'=>$user->id])}}" class="form-horizontal">
								{{method_field('patch')}}
								{{csrf_field()}}
								<div class="form-group">
									<label for="firstname" class="col-sm-3 control-label">First Name</label>
									<div class="col-sm-9">
										{{Form::text('firstname', $user->firstname, ['id'=>'firstname', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="lastname" class="col-sm-3 control-label">Last Name</label>
									<div class="col-sm-9">
										{{Form::text('lastname', $user->lastname, ['id'=>'lastname', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="company" class="col-sm-3 control-label">Company</label>
									<div class="col-sm-9">
										<?php
											$data = App\Account::orderBy('name', 'ASC')->get();
											$list = [];
											foreach($data as $account) {
												$list[$account->id] = $account->name;
											}
										?>
										{{Form::select('company', $list, $user->account->id, ['id'=>'company', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="role" class="col-sm-3 control-label">Role</label>
									<div class="col-sm-9">
										<?php
											$list = [
												'Admin' => 'Admin',
												'Owner' => 'Owner',
												'Manager' => 'Manager',
												'Staff' => 'Staff',
											];
										?>
										{{Form::select('role', $list, $user->role, ['id'=>'role', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-sm-3 control-label">Email</label>
									<div class="col-sm-9">
										{{Form::text('email', $user->email, ['id'=>'email', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="phone" class="col-sm-3 control-label">Phone</label>
									<div class="col-sm-9">
										{{Form::text('phone', $user->phone, ['id'=>'phone', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="description" class="col-sm-3 control-label">Description</label>
									<div class="col-sm-9">
										{{Form::textarea('description', $user->description, ['id'=>'description', 'class'=>'form-control', 'rows'=>'5'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Update User', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
									</div>
								</div>
							</form>
						</div>
					</div>
				</div> <!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop