<?php $__env->startSection('content'); ?>
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title"><?php echo e($currentUser->account->name); ?> Drivers <a href="<?php echo e(route('admin.drivers.create')); ?>" class="btn btn-info" style="margin-left:10px;"><i class="fa fa-plus"></i> Add</a></h4>
					<ol class="breadcrumb pull-right">
						<li><a href="<?php echo e(route('dashboard')); ?>">Anyware</a></li>
						<li class="active">Drivers</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Drivers</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th width="10%" class="text-center">Actions</th>
										<th>Name</th>
										<th width="10%" class="text-center">Rate</th>
										<th width="10%" class="text-right">Last Modified</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($drivers as $driver): ?>
										<tr class="clickable-row" data-href="<?php echo e(route('admin.drivers.show', ['id'=>$driver->id])); ?>">
											<td class="text-center actions">
												<a href="<?php echo e(route('admin.drivers.show', ['id'=>$driver->id])); ?>" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="#" title="Delete" class="text-danger"><i class="fa fa-trash"></i></a>
											</td>
											<td><?php echo e($driver->firstname); ?> <?php echo e($driver->lastname); ?></td>
											<td class="text-center"><?php echo e($driver->rate); ?></td>
											<td class="text-right"><?php echo e(date('m/d/Y g:i a', strtotime($driver->updated_at))); ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div> <!-- end col -->
			</div> <!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>