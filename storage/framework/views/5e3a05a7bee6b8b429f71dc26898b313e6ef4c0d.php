<?php $__env->startSection('content'); ?>
	<!-- Start content -->
	<div class="content">
		<div class="container">

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 class="pull-left page-title">Edit Rate</h4>
					<ol class="breadcrumb pull-right">
						<li><a href="<?php echo e(route('dashboard')); ?>">Anyware</a></li>
						<li><a href="<?php echo e(route('admin.rates.index')); ?>">Rates</a></li>
						<li><a href="<?php echo e(route('admin.rates.show', ['id'=>$rate->id])); ?>"><?php echo e($rate->name); ?></a></li>
						<li class="active">Edit</li>
					</ol>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">Company Info</h4>
						</div>
						<div class="panel-body">
							<?php echo $__env->make('errors.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
							<form method="POST" action="<?php echo e(route('admin.rates.update', ['id'=>$rate->id])); ?>" class="form-horizontal">
								<?php echo e(method_field('patch')); ?>

								<?php echo e(csrf_field()); ?>

								<div class="form-group">
									<label for="name" class="col-sm-3 control-label">Nickname</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('name', $rate->name, ['id'=>'name', 'class'=>'form-control'])); ?>

									</div>
								</div>
								<div class="form-group">
									<label for="billing_office" class="col-sm-3 control-label">Billing Office</label>
									<div class="col-sm-9">
										<?php
											$data = App\BillingOffice::leftJoin('customers', 'billing_offices.customer_id', '=', 'customers.id')->where('customers.account_id', $currentUser->account->id)->select('billing_offices.*')->get();
											$list = [];
											foreach($data as $billing_office) {
												$list[$billing_office->id] = $billing_office->name;
											}
										?>
										<?php echo e(Form::select('billing_office', $list, $rate->billing_office_id, ['id'=>'billing_office', 'class'=>'form-control'])); ?>

									</div>
								</div>
								<div class="form-group">
									<label for="chain_up_fee" class="col-sm-3 control-label">Chain Up Fee</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('chain_up_fee', $rate->chain_up_fee, ['id'=>'chain_up_fee', 'class'=>'form-control'])); ?>

									</div>
								</div>
								<div class="form-group">
									<label for="chain_up_pay" class="col-sm-3 control-label">Chain Up Driver Pay</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('chain_up_pay', $rate->chain_up_pay, ['id'=>'chain_up_pay', 'class'=>'form-control'])); ?>

									</div>
								</div>
								<div class="form-group">
									<label for="demm_fee" class="col-sm-3 control-label">Demurrage Fee</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('demm_fee', $rate->demm_fee, ['id'=>'demm_fee', 'class'=>'form-control'])); ?>

									</div>
								</div>
								<div class="form-group">
									<label for="nc_demm_hrs" class="col-sm-3 control-label">No Charge Demurrage Hrs</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('nc_demm_hrs', $rate->nc_demm_hrs, ['id'=>'nc_demm_hrs', 'class'=>'form-control'])); ?>

									</div>
								</div>
								<div class="form-group">
									<label for="divert_fee" class="col-sm-3 control-label">Divert Fee</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('divert_fee', $rate->divert_fee, ['id'=>'divert_fee', 'class'=>'form-control'])); ?>

									</div>
								</div>
								<div class="form-group">
									<label for="reject_fee" class="col-sm-3 control-label">Reject Fee</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('reject_fee', $rate->reject_fee, ['id'=>'reject_fee', 'class'=>'form-control'])); ?>

									</div>
								</div>
								<div class="form-group">
									<label for="split_fee" class="col-sm-3 control-label">Split Fee</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('split_fee', $rate->split_fee, ['id'=>'split_fee', 'class'=>'form-control'])); ?>

									</div>
								</div>
								<div class="form-group">
									<label for="masking_fee" class="col-sm-3 control-label">Masking Fee</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('masking_fee', $rate->masking_fee, ['id'=>'masking_fee', 'class'=>'form-control'])); ?>

									</div>
								</div>
								<div class="form-group">
									<label for="fsc_formula" class="col-sm-3 control-label">Fuel Surcharge Fraction</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('fsc_formula', $rate->fsc_formula, ['id'=>'fsc_formula', 'class'=>'form-control'])); ?>

										<span class="help-block">Must include <u>price</u> and <u>base_rate</u> where you want to include those values in the formula</span>
									</div>
								</div>
								<div class="form-group">
									<label for="load_barrels" class="col-sm-3 control-label">Load Barrels</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('load_barrels', $rate->load_barrels, ['id'=>'load_barrels', 'class'=>'form-control'])); ?>

									</div>
								</div>
								<div class="form-group">
									<label for="load_time" class="col-sm-3 control-label">Load Time</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('load_time', $rate->load_time, ['id'=>'load_time', 'class'=>'form-control'])); ?>

									</div>
								</div>
								<div class="form-group">
									<label for="min_bbls" class="col-sm-3 control-label">Minimum Barrels</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('min_bbls', $rate->min_bbls, ['id'=>'min_bbls', 'class'=>'form-control'])); ?>

									</div>
								</div>
								<div class="form-group">
									<label for="discount" class="col-sm-3 control-label">Discount</label>
									<div class="col-sm-9">
										<?php echo e(Form::text('discount', $rate->discount, ['id'=>'discount', 'class'=>'form-control'])); ?>

										<span class="help-block">Decimal Percentage</span>
									</div>
								</div>

								<div class="form-group">
									<label for="discount" class="col-sm-3 control-label">Default</label>
									<div class="col-sm-9">
										<?php echo e(Form::checkbox('is_default', $rate->is_default, ['id'=>'is_default', 'class'=>'form-control'])); ?>										
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<?php echo e(Form::submit('Submit Changes', ['id'=>'submit', 'class'=>'btn btn-primary pull-right'])); ?>

									</div>
								</div>
							</form>
						</div>
					</div>
				</div> <!-- end col -->
			</div><!-- end row -->

		</div> <!-- container -->
	</div> <!-- content -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>