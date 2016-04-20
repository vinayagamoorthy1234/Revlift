@extends('layouts.app')

@section('content')
			<div class="panel">
				@if(session('warning'))
					<div class="alert alert-warning" role="alert">{{ session('warning') }}</div>
				@elseif(session('success'))
					<div class="alert alert-success" role="alert">{{ session('success') }}</div>
				@elseif(session('failure'))
					<div class="alert alert-danger" role="alert">{{ session('failure') }}</div>
				@endif
				<div class="panel-heading">
					<div class="text-center logo-wrapper">
						<img src="images/logo.png" alt="Anyware Logo">
					</div>
				</div> 
				<div class="panel-body">
					<form class="form-horizontal" method="post" action="{{ url('login') }}">
						{{ csrf_field() }}
						@include('errors.form')
						<div class="form-group">
							<div class="col-xs-12">
								<input class="form-control input-lg" value="{{ old('username') }}" type="text" id="username" name="username" placeholder="Username" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<input class="form-control input-lg" type="password" id="username" name="password" placeholder="Password" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<div class="checkbox checkbox-primary">
									@if(old('remember'))
										<input id="checkbox-signup" name="remember" type="checkbox" checked>
									@else
										<input id="checkbox-signup" name="remember" type="checkbox">
									@endif
									<label for="checkbox-signup">
										Remember me
									</label>
								</div>
							</div>
						</div>
						<div class="form-group text-center m-t-40">
							<div class="col-xs-12">
								<button class="btn btn-primary btn-lg w-lg waves-effect waves-light" type="submit">Log In</button>
							</div>
						</div>
						<div class="form-group m-t-30">
							<div class="col-sm-7">
								<a href="/forgotpw"><i class="fa fa-lock"></i> Forgot your password?</a>
							</div>
						</div>
					</form>
				</div>
				<footer class="panel-footer">
					<small> &copy; {{date('Y')}} Anyware.</small>
				</footer>
			</div>					
@stop
