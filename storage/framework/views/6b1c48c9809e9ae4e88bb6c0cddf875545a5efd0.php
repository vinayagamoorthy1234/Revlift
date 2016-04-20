<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo e(isset($pageTitle) ? $pageTitle . ' | ' : ''); ?> Anyware Trucks</title>
		<!-- META INFORMATION -->
		<meta charset="UTF-8">
		<meta name="description" content="Anyware is a private trucking management system."> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- ADD GOOGLE SITE VERIFICATION META TAG HERE -->
		<meta name="google" content="nositelinkssearchbox" />
		<meta name="author" content="Revlift Technologies, LLC" />
		<meta name="robots" content="noindex,nofollow">

		<!-- STYLESHEETS -->
		<link href="<?php echo e(asset('/plugins/sweetalert/dist/sweetalert.css')); ?>" rel="stylesheet" type="text/css">
		<link href="<?php echo e(asset('/css/app.css')); ?>" rel="stylesheet" type="text/css">
		<?php if(isset($styles)) echo $styles; ?>

		<!-- SCRIPTS -->
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvIIVslXmo9UvfnKhryqYQZBTNP1jHXYE&signed_in=true"></script>
		<script src="/js/app.js"></script>
		<?php if(isset($scripts)) echo $scripts; ?>
	</head>
	<body class="fixed-left">
		<div id="wrapper">
			<!-- Top Bar Start -->
			<div class="topbar">
				<!-- LOGO -->
				<div class="topbar-left">
					<div class="text-center">
						<a href="<?php echo e(route('dashboard')); ?>" class="logo">
							<img class="large" src="/images/logo.png" alt="Anyware Logo">
							<img class="icon" src="/images/logo_icon.png" alt="Anyware Logo">
							<span><?php echo e($currentUser->account->name); ?></span>
						</a>
					</div>
				</div>
				<!-- Button mobile view to collapse sidebar menu -->
				<div class="navbar navbar-default" role="navigation">
					<div class="container">
						<div class="pull-left">
							<button class="button-menu-mobile open-left">
								<i class="fa fa-bars"></i>
							</button>
							<span class="clearfix"></span>
						</div>
						<form class="navbar-form pull-left" role="search">
							<div class="form-group">
								<input type="text" class="form-control search-bar" placeholder="Type here for search...">
							</div>
							<button type="submit" class="btn btn-search"><i class="fa fa-search"></i></button>
						</form>
						<ul class="nav navbar-nav navbar-right pull-right">
							<li class="dropdown hidden-xs">
								<a href="#" data-target="#" class="dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="true">
									<i class="md md-notifications"></i> <span class="badge badge-xs badge-danger">3</span>
								</a>
								<ul class="dropdown-menu dropdown-menu-lg">
									<li class="text-center notifi-title">Notification</li>
									<li class="list-group">
										<!-- list item-->
										<a href="javascript:void(0);" class="list-group-item">
											<div class="media">
												<div class="pull-left">
													<em class="fa fa-user-plus fa-2x text-info"></em>
												</div>
												<div class="media-body clearfix">
													<div class="media-heading">New user registered</div>
													<p class="m-0">
														<small>You have 10 unread messages</small>
													</p>
												</div>
											</div>
										</a>
										<!-- list item-->
										<a href="javascript:void(0);" class="list-group-item">
											<div class="media">
												<div class="pull-left">
													<em class="fa fa-diamond fa-2x text-primary"></em>
												</div>
												<div class="media-body clearfix">
													<div class="media-heading">New settings</div>
													<p class="m-0">
														<small>There are new settings available</small>
													</p>
												</div>
											</div>
										</a>
										<!-- list item-->
										<a href="javascript:void(0);" class="list-group-item">
											<div class="media">
												<div class="pull-left">
													<em class="fa fa-bell-o fa-2x text-danger"></em>
												</div>
												<div class="media-body clearfix">
													<div class="media-heading">Updates</div>
													<p class="m-0"> <small>There are <span class="text-primary">2</span> new updates available</small> </p>
												</div>
											</div>
										</a>
										<!-- last list item -->
										<a href="javascript:void(0);" class="list-group-item">
											<small>See all notifications</small>
										</a>
									</li>
								</ul>
							</li>
							<li class="hidden-xs">
								<a href="#" id="btn-fullscreen" class="waves-effect"><i class="md md-crop-free"></i></a>
							</li>
							<li class="dropdown">
								<a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="true"><img src="/images/todd_placeholder.jpg" alt="user-img" class="img-circle"> </a>
								<ul class="dropdown-menu">
									<li><a href="javascript:void(0)"><i class="md md-face-unlock"></i> Profile</a></li>
									<li><a href="javascript:void(0)"><i class="md md-settings"></i> Settings</a></li>
									<li><a href="<?php echo e(url('/logout')); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
								</ul>
							</li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
			<!-- Top Bar End -->
			<!-- ========== Left Sidebar Start ========== -->
			<div class="left side-menu">
				<div class="sidebar-inner slimscrollleft">
					<div class="user-details">
						<div class="pull-left">
							<img src="/images/todd_placeholder.jpg" alt="" class="thumb-md img-circle">
						</div>
						<div class="user-info">
							<div class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo e($currentUser->firstname.' '.$currentUser->lastname); ?> <span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li><a href="javascript:void(0)"><i class="md md-face-unlock"></i> Profile</a></li>
									<li><a href="javascript:void(0)"><i class="md md-settings"></i> Settings</a></li>
									<li><a href="<?php echo e(url('/logout')); ?>"><i class="fa fa-power-off"></i> Logout</a></li>
								</ul>
							</div>
							<p class="text-muted m-0"><?php echo e($currentUser->role); ?></p>
						</div>
					</div>
					<!--- Divider -->
					<div id="sidebar-menu">
						<?php if($currentUser->role=='Admin'): ?>
						<ul>
							<li><a href="<?php echo e(route('admin.accounts.index')); ?>" class="waves-effect waves-light <?php echo e(Request::segment(2)=='accounts' ? 'active':''); ?>"><i class="fa fa-briefcase"></i><span> Accounts</span></a></li>
							<li><a href="<?php echo e(url('admin/users')); ?>" class="waves-effect waves-light <?php echo e(Request::segment(2)=='users' ? 'active':''); ?>"><i class="fa fa-users"></i><span> Users</span></a></li>
						</ul>
						<hr />
						<?php elseif($currentUser->role=='Owner' || $currentUser->role=='Manager'): ?>
						<ul>
							<li><a href="<?php echo e(url('admin/users')); ?>" class="waves-effect waves-light <?php echo e(Request::segment(2)=='users' ? 'active':''); ?>"><i class="fa fa-users"></i><span> Users</span></a></li>
						</ul>
						<hr />
						<?php endif; ?>
						<ul>
							<li>
								<a href="<?php echo e(route('dashboard')); ?>" class="waves-effect waves-light <?php echo e(Request::segment(2)=='dashboard' ? 'active':''); ?>"><i class="md md-home"></i><span> Dashboard</span></a>
							</li>
							<li>
								<a href="<?php echo e(route('admin.devices.index')); ?>" class="waves-effect waves-light"><i class="md md-tablet-android"></i> <span>Manage Devices</span></a>
							</li>
							<li>
								<a href="<?php echo e(route('admin.shipments.index')); ?>" class="waves-effect waves-light <?php echo e(Request::segment(2)=='shipments' ? 'active':''); ?>"><i class="fa fa-archive"></i><span> Shipments</span></a>
							</li>
							<li class="has_sub">
								<a href="#" class="waves-effect waves-light"><i class="flaticon flaticon-pumpjack"></i> <span> Leases</span> <span class="pull-right"><i class="md md-add"></i></span></a>
								<ul class="list-unstyled">
									<li><a href="<?php echo e(route('admin.leases.index')); ?>" class="<?php echo e(Request::segment(2)=='leases' ? 'active':''); ?>">View Leases</a></li>
									<li><a href="<?php echo e(route('admin.tanks.index')); ?>" class="<?php echo e(Request::segment(2)=='tanks' ? 'active':''); ?>">Tanks</a></li>
									<li><a href="<?php echo e(route('admin.strappings.index')); ?>" class="<?php echo e(Request::segment(2)=='strappings' ? 'active':''); ?>">Tank Strappings</a></li>
								</ul>
							</li>
							<li class="has_sub">
								<a href="#" class="waves-effect waves-light"><i class="flaticon flaticon-refinery"></i><span> Depots</span><span class="pull-right"><i class="md md-add"></i></span></a>
								<ul class="list-unstyled">
									<li><a href="<?php echo e(route('admin.depots.index')); ?>" class="<?php echo e(Request::segment(2)=='depots' ? 'active':''); ?>">View Depots</a></li>
									<li><a href="<?php echo e(route('admin.allocations.index')); ?>" class="<?php echo e(Request::segment(2)=='allocations' ? 'active':''); ?>">Depot Allocations</a></li>
									<li><a href="<?php echo e(route('admin.headers.index')); ?>" class="<?php echo e(Request::segment(2)=='headers' ? 'active':''); ?>">Depot Headers</a></li>
								</ul>
							</li>
							<li class="has_sub">
								<a href="#" class="waves-effect waves-light"><i class="fa fa-users"></i><span> Customers</span><span class="pull-right"><i class="md md-add"></i></span></a>
								<ul class="list-unstyled">
									<li><a href="<?php echo e(route('admin.customers.index')); ?>" class="<?php echo e(Request::segment(2)=='customers' ? 'active':''); ?>">View Customers</a></li>
									<li><a href="<?php echo e(route('admin.billing.index')); ?>" class="<?php echo e(Request::segment(2)=='billing' ? 'active':''); ?>">Billing Offices</a></li>
									<li><a href="<?php echo e(route('admin.operators.index')); ?>" class="<?php echo e(Request::segment(2)=='operators' ? 'active':''); ?>">Operators</a></li>
								</ul>
							</li>
							<li>
								<a href="<?php echo e(route('admin.drivers.index')); ?>" class="waves-effect waves-light <?php echo e(Request::segment(2)=='drivers' ? 'active':''); ?>"><i class="flaticon flaticon-steering-wheel"></i><span> Drivers</span></a>
							</li>
							<li>
								<a href="<?php echo e(route('admin.trucks.index')); ?>" class="waves-effect waves-light <?php echo e(Request::segment(2)=='trucks' ? 'active':''); ?>"><i class="flaticon flaticon-truck"></i><span> Trucks</span></a>
							</li>
							<li>
								<a href="<?php echo e(route('admin.trailers.index')); ?>" class="waves-effect waves-light <?php echo e(Request::segment(2)=='trailers' ? 'active':''); ?>"><i class="flaticon flaticon-freight"></i><span> Trailers</span></a>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- Left Sidebar End --> 
			<!-- ============================================================== -->
			<!-- Start right Content here -->
			<!-- ============================================================== -->                      
			<div class="content-page">
				<?php echo $__env->yieldContent('content'); ?>
				<footer class="footer text-right">
					&copy; <?php echo e(date('Y')); ?> Anyware.
					<br />
					<small>Some sidebar icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> and is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></small>
				</footer>
			</div>
			<!-- ============================================================== -->
			<!-- End Right content here -->
			<!-- ============================================================== -->
		</div>
		<!-- ============================================================== -->
		<!-- Start modals and alerts here -->
		<!-- ============================================================== -->
		<?php if(session('warning')): ?>
			<div class="alert alert-warning alert-float" role="alert">
				<?php echo e(session('warning')); ?>

				<button type="button" class="close" data-dismiss="alert">
  				<span>&times;</span>
				</button>
			</div>
		<?php elseif(session('success')): ?>
			<div class="alert alert-success alert-float" role="alert">
				<?php echo e(session('success')); ?>

				<button type="button" class="close" data-dismiss="alert">
  				<span>&times;</span>
				</button>
			</div>
		<?php elseif(session('failure')): ?>
			<div class="alert alert-danger alert-float" role="alert">
				<?php echo e(session('failure')); ?>

				<button type="button" class="close" data-dismiss="alert">
  				<span>&times;</span>
				</button>
			</div>
		<?php endif; ?>
		<!-- ============================================================== -->
		<!-- End modals and alerts here -->
		<!-- ============================================================== -->
		<script>
        var resizefunc = [];
    </script>

    <!-- jQuery  -->
    <script src="<?php echo e(asset('/js/detect.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/fastclick.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery.slimscroll.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery.blockUI.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/waves.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery.nicescroll.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/jquery.scrollTo.min.js')); ?>"></script>

    <script src="<?php echo e(asset('/js/jquery.app.js')); ?>"></script>

    <!-- moment js  -->
    <script src="<?php echo e(asset('/plugins/moment/moment.js')); ?>"></script>
    
    <!-- counters  -->
    <script src="<?php echo e(asset('/plugins/waypoints/lib/jquery.waypoints.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/counterup/jquery.counterup.js')); ?>"></script>
    
    <!-- sweet alert  -->
    <script src="<?php echo e(asset('/plugins/sweetalert/dist/sweetalert.min.js')); ?>"></script>
    
    <?php if(Request::segment(2)=='dashboard'): ?>
    <!-- flot Chart -->
    <script src="<?php echo e(asset('/plugins/flot-chart/jquery.flot.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/flot-chart/jquery.flot.time.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/flot-chart/jquery.flot.tooltip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/flot-chart/jquery.flot.resize.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/flot-chart/jquery.flot.pie.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/flot-chart/jquery.flot.selection.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/flot-chart/jquery.flot.stack.js')); ?>"></script>
    <script src="<?php echo e(asset('/plugins/flot-chart/jquery.flot.crosshair.js')); ?>"></script>

    <!-- dashboard  -->
    <script src="<?php echo e(asset('js/pages/jquery.dashboard.js')); ?>"></script>
    <?php endif; ?>
    
    <script type="text/javascript">
      jQuery(document).ready(function($) {
        $('.counter').counterUp({
          delay: 100,
          time: 1200
        });
      });
    </script>
	</body>
</html>
