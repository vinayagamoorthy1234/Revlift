@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Add New User</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.users.index')}}">Users</a></li>
						<li class="active">New</li>
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
							@include('errors.form')
							<form method="POST" action="{{route('admin.users.store')}}" class="form-horizontal">
								{{csrf_field()}}
								<div class="form-group">
									<label for="firstname" class="col-sm-3 control-label">First Name</label>
									<div class="col-sm-9">
										{{Form::text('firstname', '', ['id'=>'firstname', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="lastname" class="col-sm-3 control-label">Last Name</label>
									<div class="col-sm-9">
										{{Form::text('lastname', '', ['id'=>'lastname', 'class'=>'form-control'])}}
									</div>
								</div>
								@if($currentUser->role=="Admin")
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
										{{Form::select('company', $list, $currentUser->account->id, ['id'=>'company', 'class'=>'form-control'])}}
									</div>
								</div>
								@else
								<input type="hidden" name="company" id="company" value="{{$currentUser->account->id}}">
								@endif
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
										{{Form::select('role', $list, 'Staff', ['id'=>'role', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="email" class="col-sm-3 control-label">Email</label>
									<div class="col-sm-9">
										{{Form::text('email', '', ['id'=>'email', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="phone" class="col-sm-3 control-label">Phone</label>
									<div class="col-sm-9">
										{{Form::text('phone', '', ['id'=>'phone', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="description" class="col-sm-3 control-label">Description</label>
									<div class="col-sm-9">
										{{Form::textarea('description', '', ['id'=>'description', 'class'=>'form-control', 'rows'=>'5'])}}
									</div>
								</div>
								<br />
								<div class="form-group">
									<label for="username" class="col-sm-3 control-label">Username</label>
									<div class="col-sm-9">
										{{Form::text('username', '', ['id'=>'username', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-3 control-label">Temp Password</label>
									<div class="col-sm-9">
										{{Form::password('password', ['name'=>'password', 'id'=>'password', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Create User', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
									</div>
								</div>
							</form>
						</div>
					</div>
				</div> <!-- end col -->
			</div>

		</div> <!-- container -->
	</div> <!-- content -->
@stop