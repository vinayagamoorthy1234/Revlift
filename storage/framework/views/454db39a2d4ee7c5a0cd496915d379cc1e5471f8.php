<?php $__env->startSection('content'); ?>
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Welcome <?php echo e($currentUser->firstname); ?>!</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="#">Anyware</a></li>
						<li class="active">Dashboard</li>
					</ol>
				</div>
			</div>

			<!-- Start Widget -->
			<div class="row">
				<div class="col-md-6 col-sm-6 col-lg-3">
					<div class="mini-stat clearfix bx-shadow bg-primary">
						<span class="mini-stat-icon"><i class="flaticon-barrels"></i></span>
						<div class="mini-stat-info text-right">
							<span class="counter">30,232</span>
							BBLs Hauled for <?php echo e(Date('F')); ?>

						</div>
						<div class="tiles-progress">
							<div class="m-t-20">
								<h5 class="text-uppercase text-white m-0">Total BBLs Hauled <span class="pull-right">456,583</span></h5>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6 col-sm-6 col-lg-3">
					<div class="mini-stat clearfix bg-purple bx-shadow">
						<span class="mini-stat-icon"><i class="flaticon-barrel"></i></span>
						<div class="mini-stat-info text-right">
							<span class="counter">5,210</span>
							BBLs Hauled for <?php echo e(Date('F d')); ?>

						</div>
						<div class="tiles-progress">
							<div class="m-t-20">
								<h5 class="text-uppercase text-white m-0">Avg. Daily BBLs <span class="pull-right">43,498</span></h5>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6 col-sm-6 col-lg-3">
					<div class="mini-stat clearfix bg-pink bx-shadow">
						<span class="mini-stat-icon"><i class="flaticon-dollar-chart"></i></span>
						<div class="mini-stat-info text-right">
							<span class="counter">12,321,637</span>
							Revenue for <?php echo e(Date('F')); ?>

						</div>
						<div class="tiles-progress">
							<div class="m-t-20">
								<h5 class="text-uppercase text-white m-0">Total Gross Revenue <span class="pull-right">45,123,234</span></h5>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6 col-sm-6 col-lg-3">
					<div class="mini-stat clearfix bg-success bx-shadow">
						<span class="mini-stat-icon"><i class="ion-social-usd"></i></span>
						<div class="mini-stat-info text-right">
							<span class="counter">20,999</span>
							Revenue for <?php echo e(Date('F d')); ?>

						</div>
						<div class="tiles-progress">
							<div class="m-t-20">
								<h5 class="text-uppercase text-white m-0">Avg. Daily Revenue <span class="pull-right">325,335</span></h5>
							</div>
						</div>
					</div>
				</div>
			</div> 
			<!-- End row-->


			<div class="row">

				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Highest Driver Output</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-hover">
								<thead>
									<tr>
										<th>First Name</th>
										<th>Last Name</th>
										<th>BBLs</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Todd</td>
										<td>Kuehnl</td>
										<td>10,000</td>
									</tr>
									<tr>
										<td>Joey</td>
										<td>Santos</td>
										<td>12,000</td>
									</tr>
									<tr>
										<td>Ryan</td>
										<td>Ginnow</td>
										<td>4,000</td>
									</tr>
									<tr>
										<td>Evan</td>
										<td>Buchert</td>
										<td>14,000</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div> <!-- end col -->

				<div class="col-lg-6">
					<div class="portlet"><!-- /portlet heading -->
						<div class="portlet-heading">
							<h3 class="portlet-title text-dark text-uppercase">
								Current Driver Locations
							</h3>
							<div class="portlet-widgets">
								<a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
								<span class="divider"></span>
								<a data-toggle="collapse" data-parent="#accordion1" href="#portlet3"><i class="ion-minus-round"></i></a>
								<span class="divider"></span>
								<a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div id="portlet3" class="panel-collapse collapse in">
							<div class="portlet-body">
								<div class="row">
									<div class="col-md-12">
										<div id="map" style="height:411px"></div>
										<script>
										function initMap() {
										  var latLngObj = [
										  	{lat: 29.2858130, lng: -81.0558890},
										  	{lat: 32.7766640, lng: -96.7969880}
										  ];

										  var map = new google.maps.Map(document.getElementById('map'), {
										    zoom: 4,
										    center: {lat: 39.833333, lng: -98.583333}
										  });

										  $.each(latLngObj, function(key, value) {
										  	new google.maps.Marker({
											    position: value,
											    map: map
											  });
										  });
										}

										</script>
										<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvIIVslXmo9UvfnKhryqYQZBTNP1jHXYE&signed_in=true&callback=initMap"></script>
									</div>
								</div>
							</div>
						</div>
					</div> <!-- /Portlet -->
				</div> <!-- end col -->
			</div> <!-- End row -->


			<div class="row">
				<div class="col-lg-6">
					<div class="portlet"><!-- /portlet heading -->
						<div class="portlet-heading">
							<h3 class="portlet-title text-dark text-uppercase">
								Quarterly BBLs
							</h3>
							<div class="portlet-widgets">
								<a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
								<span class="divider"></span>
								<a data-toggle="collapse" data-parent="#accordion1" href="#portlet1"><i class="ion-minus-round"></i></a>
								<span class="divider"></span>
								<a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div id="portlet1" class="panel-collapse collapse in">
							<div class="portlet-body">
								<div class="row">
									<div class="col-md-12">
										<div id="pie-chart">
											<div id="pie-chart-container" class="flot-chart" style="height: 320px">
											</div>
										</div>

										<div class="row text-center m-t-30">
											<div class="col-sm-6">
												<h4 class="counter">86,956</h4>
												<small class="text-muted"> Weekly Report</small>
											</div>
											<div class="col-sm-6">
												<h4 class="counter">86,69</h4>
												<small class="text-muted">Monthly Report</small>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> <!-- /Portlet -->
				</div> <!-- end col -->

				<div class="col-lg-6">
					<div class="portlet"><!-- /portlet heading -->
						<div class="portlet-heading">
							<h3 class="portlet-title text-dark text-uppercase">
								Monthly Revenue
							</h3>
							<div class="portlet-widgets">
								<a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
								<span class="divider"></span>
								<a data-toggle="collapse" data-parent="#accordion1" href="#portlet2"><i class="ion-minus-round"></i></a>
								<span class="divider"></span>
								<a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div id="portlet2" class="panel-collapse collapse in">
							<div class="portlet-body">
								<div class="row">
									<div class="col-md-12">
										<div id="website-stats" style="position: relative;height: 320px"></div>
                    <div class="row text-center m-t-30">
                      <div class="col-sm-6">
                        <h4 class="counter">6,956</h4>
                        <small class="text-muted">Daily Report</small>
                      </div>
                      <div class="col-sm-6">
                        <h4 class="counter">86,669</h4>
                        <small class="text-muted">Monthly Report</small>
                      </div>
                    </div>
									</div>
								</div>
							</div>
						</div>
					</div> <!-- /Portlet -->
				</div> <!-- end col -->
			</div> <!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>