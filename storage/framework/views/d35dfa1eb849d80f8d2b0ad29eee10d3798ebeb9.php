<?php $__env->startSection('content'); ?>
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<a href="<?php echo e(route('admin.billing.show', $rate->billing_office_id)); ?>" class="pull-left btn btn-default"><i class="fa fa-arrow-left"></i> Back to <?php echo e($rate->billing_office->name); ?></a>
					<ol class="breadcrumb pull-right">
						<li><a href="<?php echo e(route('dashboard')); ?>">Anyware</a></li>
						<li><a href="<?php echo e(route('admin.rates.index')); ?>">Rates</a></li>
						<li class="active"><?php echo e($rate->name); ?></li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<h3 class="pull-left page-title"><?php echo e($rate->name); ?></h3>
					<input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
					<a href="javascript:;" class="pull-right btn btn-danger" id="sa-warning"><i class="fa fa-remove"></i> Delete Rate</a>
					<a href="<?php echo e(route('admin.rates.edit', ['id'=>$rate->id])); ?>" class="pull-right btn btn-warning"><i class="fa fa-pencil"></i> Edit Rate</a>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Rate Info</h4>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-12">
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Nickname</strong></div>
										<div class="col-sm-8">
											<?php setlocale(LC_MONETARY, 'en_US'); ?>
											<?php echo e($rate->name); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Billing Office</strong></div>
										<div class="col-sm-8">
											<?php echo e($rate->billing_office->name); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Chain Up Fee</strong></div>
										<div class="col-sm-8">
											<?php /* <?php echo e(money_format('%n', $rate->chain_up_fee)); ?> */ ?>
											<?php echo e($rate->chain_up_fee); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Chain Up Driver Pay</strong></div>
										<div class="col-sm-8">
											<?php /* money_format('%n', $rate->chain_up_pay)*/ ?>
											<?php echo e($rate->chain_up_pay); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Demurrage Fee</strong></div>
										<div class="col-sm-8">
											<?php /* money_format('%n', $rate->demm_fee) */ ?>
											<?php echo e($rate->demm_fee); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>No Charge Demurrage Hrs</strong></div>
										<div class="col-sm-8">
											<?php echo e($rate->nc_demm_hrs); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Divert Fee</strong></div>
										<div class="col-sm-8">
											<?php /* money_format('%n', $rate->divert_fee) */ ?>
											<?php echo e($rate->divert_fee); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Reject Fee</strong></div>
										<div class="col-sm-8">
											<?php /* money_format('%n', $rate->reject_fee) */ ?>
										     <?php echo e($rate->reject_fee); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Split Fee</strong></div>
										<div class="col-sm-8">
											<?php /* money_format('%n', $rate->split_fee) */ ?>
											<?php echo e($rate->split_fee); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Divert Fee</strong></div>
										<div class="col-sm-8">
											<?php /* money_format('%n', $rate->divert_fee) */ ?>
											<?php echo e($rate->divert_fee); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Masking Fee</strong></div>
										<div class="col-sm-8">
											<?php /* money_format('%n', $rate->masking_fee) */ ?>
											<?php echo e($rate->masking_fee); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Fuel Surcharge Formula</strong></div>
										<div class="col-sm-8">
											<?php echo e($rate->fsc_formula); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Load Barrels</strong></div>
										<div class="col-sm-8">
											<?php echo e($rate->load_barrels); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Load Time</strong></div>
										<div class="col-sm-8">
											<?php echo e($rate->load_time); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Minimum Barrels</strong></div>
										<div class="col-sm-8">
											<?php echo e($rate->min_bbls); ?>

										</div>
									</div>
									<div class="row">
										<div class="col-sm-4 text-right"><strong>Discount</strong></div>
										<div class="col-sm-8">
											<?php echo e($rate->discount); ?>

										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>