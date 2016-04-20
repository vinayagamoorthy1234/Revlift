<?php $__env->startSection('content'); ?>
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">All Tanks <a href="<?php echo e(route('admin.tanks.create')); ?>" class="btn btn-info" style="margin-left:10px;"><i class="fa fa-plus"></i> Add</a></h4>
					<ol class="breadcrumb pull-right">
						<li><a href="<?php echo e(route('dashboard')); ?>">Anyware</a></li>
						<li class="active">Tanks</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Tanks</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th width="10%" class="text-center">Actions</th>
										<th>Lease Name</th>
										<th>Tank Number</th>
										<th>Size</th>
										<th width="15%">Created At</th>
										<th width="15%">Last Modified</th>
									</tr>
								</thead>
								<tbody>
									<div style="display:none" id="token" data-token="<?php echo e(csrf_token()); ?>"></div>
									<?php foreach($tanks as $tank): ?>
										<tr class="clickable-row" data-href="<?php echo e(route('admin.tanks.show', ['id'=>$tank->id])); ?>">
											<td class="text-center actions">
												<a href="<?php echo e(route('admin.tanks.show', ['id'=>$tank->id])); ?>" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="javascript:;" title="Delete" class="sa-warning text-danger" data-tank-id="<?php echo e($tank->id); ?>"><i class="fa fa-trash"></i></a>
											</td>
											<td><?php echo e($tank->lease->name); ?> (<?php echo e($tank->lease->number); ?>)</td>
											<td><?php echo e($tank->number); ?></td>
											<td><?php echo e($tank->size); ?></td>
											<td><?php echo e(date('m/d/Y', strtotime($tank->created_at))); ?></td>
											<td><?php echo e(date('m/d/Y', strtotime($tank->updated_at))); ?></td>
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