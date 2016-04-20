<?php $__env->startSection('content'); ?>
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">All Rates <a href="<?php echo e(route('admin.rates.create')); ?>" class="btn btn-info" style="margin-left:10px;"><i class="fa fa-plus"></i> Add</a></h4>
					<ol class="breadcrumb pull-right">
						<li><a href="<?php echo e(route('dashboard')); ?>">Anyware</a></li>
						<li class="active">Rates</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Rates</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center">Actions</th>
										<th>Nickname</th>
										<th>Billing Office</th>
										<th>FSC</th>
										<th>Discount</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($rates as $rate): ?>
										<tr class="clickable-row" data-href="<?php echo e(route('admin.rates.show', ['id'=>$rate->id])); ?>">
											<td class="text-center actions">
												<a href="<?php echo e(route('admin.rates.show', ['id'=>$rate->id])); ?>" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="#" title="Delete" class="text-danger"><i class="fa fa-trash"></i></a>
											</td>
											<td><?php echo e($rate->name); ?></td>
											<td><?php echo e($rate->billing_office->name); ?></td>
											<td><?php echo e($rate->fsc); ?></td>
											<td><?php echo e($rate->discount*100); ?>%</td>
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