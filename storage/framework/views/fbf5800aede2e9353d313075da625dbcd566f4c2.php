<?php $__env->startSection('content'); ?>
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">All Depot Allocations <a href="<?php echo e(route('admin.allocations.create')); ?>" class="btn btn-info" style="margin-left:10px;"><i class="fa fa-plus"></i> Add</a></h4>
					<ol class="breadcrumb pull-right">
						<li><a href="<?php echo e(route('dashboard')); ?>">Anyware</a></li>
						<li class="active">Depot Allocations</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Depot Allocations</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th width="10%" class="text-center">Actions</th>
										<th>Depot</th>
										<th>BBLs</th>
										<th>BBLS Revised</th>
										<th>Month/Year</th>
										<th width="15%">Revision Date</th>
									</tr>
								</thead>
								<tbody>
									<div style="display:none" id="token" data-token="<?php echo e(csrf_token()); ?>"></div>
									<?php foreach($allocations as $allocation): ?>
										<tr class="clickable-row" data-href="<?php echo e(route('admin.allocations.show', ['id'=>$allocation->id])); ?>">
											<td class="text-center actions">
												<a href="<?php echo e(route('admin.allocations.show', ['id'=>$allocation->id])); ?>" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="javascript:;" title="Delete" class="sa-warning text-danger" data-allocation-id="<?php echo e($allocation->id); ?>"><i class="fa fa-trash"></i></a>
											</td>
											<td><?php echo e($allocation->depot->name); ?></td>
											<td><?php echo e($allocation->bbls); ?></td>
											<td><?php echo e($allocation->bbls_revised); ?></td>
											<td><?php echo e(date('m/Y', strtotime($allocation->month_year))); ?></td>
											<td><?php echo e(date('m/d/Y', strtotime($allocation->updated_at))); ?></td>
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