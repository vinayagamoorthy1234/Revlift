@extends('layouts.admin')

@section('content')
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="{{route('admin.trailers.index')}}" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to Trailers</a>
					<ol class="breadcrumb pull-right">
						<li><a href="{{route('dashboard')}}">Anyware</a></li>
						<li><a href="{{route('admin.trailers.index')}}">Trailers</a></li>
						<li class="active">Trailer #{{$trailer->trailer_number}}</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title">Trailer #{{$trailer->trailer_number}}</h3>
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Trailer</a>
					<a href="{{route('admin.trailers.edit', ['id'=>$trailer->id])}}" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Trailer</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Trailer Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Trailer ID</strong></div>
								<div class="col-sm-9">
									{{$trailer->trailer_number}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Owner</strong></div>
								<div class="col-sm-9">
									{{$trailer->owner}}
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3 text-right"><strong>Rate</strong></div>
								<div class="col-sm-9">
									{{$trailer->rate}}
								</div>
							</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
@stop