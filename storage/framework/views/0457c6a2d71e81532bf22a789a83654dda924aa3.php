<?php $__env->startSection('content'); ?>
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">All Users <a href="<?php echo e(route('admin.users.create')); ?>" class="btn btn-info" style="margin-left:10px;"><i class="fa fa-plus"></i> Add</a></h4>
					<ol class="breadcrumb pull-right">
						<li><a href="<?php echo e(route('dashboard')); ?>">Anyware</a></li>
						<li class="active">Users</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Users</h4>
						</div>
						<div class="panel-body">
							<table id="datatable" class="table table-striped table-bordered table-hover">
								<thead>
									<tr>
										<th class="text-center">Actions</th>
										<th>Name</th>
										<th>Company</th>
										<th>Description</th>
										<th class="text-right">Created At</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($users as $user): ?>
										<tr class="clickable-row" data-href="<?php echo e(route('admin.users.show', ['id'=>$user->id])); ?>">
											<td class="text-center actions">
												<a href="<?php echo e(route('admin.drivers.show', ['id'=>$user->id])); ?>" title="View" class="text-primary"><i class="fa fa-eye"></i></a>
												<a href="#" title="Delete" class="text-danger"><i class="fa fa-trash"></i></a>
											</td>
											<td><?php echo e($user->firstname); ?> <?php echo e($user->lastname); ?></td>
											<td><?php echo e($user->account->name); ?></td>
											<td><?php echo e($user->description); ?></td>
											<td class="text-right"><?php echo e(date('m/d/Y g:i a', strtotime($user->created_at))); ?></td>
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