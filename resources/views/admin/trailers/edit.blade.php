@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Edit Trailer</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.trailers.index')}}">Trailers</a></li>
						<li><a href="{{route('admin.trailers.show', ['id'=>$trailer->id])}}">Trailer #{{$trailer->trailer_id}}</a></li>
						<li class="active">Edit</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Trailer Info</h4>
						</div>
						<div class="panel-body">
							@include('errors.form')
							<form method="POST" action="{{route('admin.trailers.update', ['id'=>$trailer->id])}}" class="form-horizontal">
								{{method_field('patch')}}
								{{csrf_field()}}
								<div class="form-group">
									<label for="trailer_id" class="col-sm-3 control-label">Trailer ID</label>
									<div class="col-sm-9">
										{{Form::text('trailer_id', $trailer->trailer_id, ['id'=>'trailer_id', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="owner" class="col-sm-3 control-label">Owner</label>
									<div class="col-sm-9">
										{{Form::text('owner', $trailer->owner, ['id'=>'owner', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<label for="rate" class="col-sm-3 control-label">Owner</label>
									<div class="col-sm-9">
										{{Form::text('rate', $trailer->rate, ['id'=>'rate', 'class'=>'form-control'])}}
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										{{Form::submit('Submit Changes', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])}}
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