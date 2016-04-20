<?php $__env->startSection('content'); ?>
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">All Depots <a href="<?php echo e(route('admin.depots.create')); ?>" class="btn btn-info" style="margin-left:10px;"><i class="fa fa-plus"></i> Add</a></h4>
					<ol class="breadcrumb pull-right">
						<li><a href="<?php echo e(route('dashboard')); ?>">Anyware</a></li>
						<li class="active">Depots</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Depots</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th width="10%" class="text-center">Actions</th>
										<th>Code</th>
										<th>Name</th>
										<th>Latitude</th>
										<th>Longitude</th>
										<th width="15%">Created At</th>
										<th width="15%">Last Modified</th>
									</tr>
								</thead>
								<tbody>
									<div style="display:none" id="token" data-token="<?php echo e(csrf_token()); ?>"></div>
									<?php foreach($depots as $depot): ?>
										<tr class="clickable-row" data-href="<?php echo e(route('admin.depots.show', ['id'=>$depot->id])); ?>">
											<td class="text-center actions">
												<a href="<?php echo e(route('admin.depots.show', ['id'=>$depot->id])); ?>" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="javascript:;" title="Delete" class="sa-warning text-danger" data-depot-id="<?php echo e($depot->id); ?>"><i class="fa fa-trash"></i></a>
											</td>
											<td><?php echo e($depot->code); ?></td>
											<td><?php echo e($depot->name); ?></td>
											<td class="latitude"><?php echo e($depot->latitude); ?></td>
											<td class="longitude"><?php echo e($depot->longitude); ?></td>
											<td><?php echo e(date('m/d/Y', strtotime($depot->created_at))); ?></td>
											<td><?php echo e(date('m/d/Y', strtotime($depot->updated_at))); ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div> <!-- end col -->
			</div> <!-- end row -->
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Depot Map</h4>
						</div>
						<div class="panel-body">
							<div id="map" style="min-height:455px"></div>
						</div>
					</div>
				</div>
			</div>

		</div> <!-- container -->
	</div> <!-- content -->

<script>
	$(document).ready(function() {
		// delay between geocode requests - at the time of writing, 100 miliseconds seems to work well
		var delay = 100;

		// ====== Create map objects ======
		var latlng = new google.maps.LatLng(39.833333, -98.583333);
		var mapOptions = {
			zoom: 4,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		var geo = new google.maps.Geocoder(); 
		var map = new google.maps.Map(document.getElementById("map"), mapOptions);
		var bounds = new google.maps.LatLngBounds();

		// ====== Geocoding ======
		function getAddress(latlng, next) {
			console.log('checking location');
			geo.geocode({location:latlng}, function (results,status)
				{ 
					// If that was successful
					if (status == google.maps.GeocoderStatus.OK) {
						// Lets assume that the first marker is the one we want
						var p = results[0].geometry.location;
						var lat=p.lat();
						var lng=p.lng();
						// Output the data
						var msg = 'lat=' +lat+ ' / lng=' +lng+ ' (delay='+delay+'ms)';
						console.log(msg);
						// Create a marker
						createMarker(results[0].formatted_address,lat,lng);
					}
					// ====== Decode the error status ======
					else {
						var withError = true;
						// === if we were sending the requests to fast, try this one again and increase the delay
						if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
							console.log('over query limit');
							// nextLocation--;
							delay++;
							console.log('delay is now '+delay);
						} else {
							var reason="Code "+status;
							var msg = 'error=' +reason+ '(delay='+delay+'ms)<br>';
							console.log(msg);
						}   
					}
					console.log('going to next');
					next(withError);
				}
			);
		}

		// ======= Function to create a marker
		function createMarker(add,lat,lng) {
			var infowindow = new google.maps.InfoWindow();
			var contentString = add;
			var marker = new google.maps.Marker({
				position: new google.maps.LatLng(lat,lng),
				map: map,
				zIndex: Math.round(latlng.lat()*-100000)<<5,
				icon: {
					url: '/images/depot.png',
					scaledSize: new google.maps.Size(48, 48),
				}
			});

			infowindow.setContent(contentString); 
			infowindow.open(map, marker); // Auto open marker info

			google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map,marker);
			});

			bounds.extend(marker.position);
		}

		var locations = [];
		function getLocations() {
			$('tbody tr').each(function(i) {
				$this = $(this);
				locations[i] = [];
				if($this.find(".latitude")) locations[i]['lat'] = parseFloat($this.find(".latitude").text());
				if($this.find(".longitude")) locations[i]['lng'] = parseFloat($this.find(".longitude").text());
			});

			console.log(locations);
		}

		// ======= Global variable to remind us what to do next
		var nextLocation = 0;

		// ======= Function to call the next Geocode operation when the reply comes back

		function theNext(withError) {
			console.log('In next: '+nextLocation+'<'+locations.length);
			if(nextLocation < locations.length) {
				setTimeout(getAddress(locations[nextLocation],theNext), delay);
				if(!withError) nextLocation++;
			} else {
				// We're done. Show map bounds
				map.fitBounds(bounds);
			}
		}

		// ======= Call that function for the first time =======
		getLocations();
		theNext();

		// ======= Load them all before the table plugin is set =======
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>