<?php $__env->startSection('content'); ?>
			<div class="panel">
				<?php if(session('warning')): ?>
					<div class="alert alert-warning" role="alert"><?php echo e(session('warning')); ?></div>
				<?php elseif(session('success')): ?>
					<div class="alert alert-success" role="alert"><?php echo e(session('success')); ?></div>
				<?php elseif(session('failure')): ?>
					<div class="alert alert-danger" role="alert"><?php echo e(session('failure')); ?></div>
				<?php endif; ?>
				<div class="panel-heading">
					<div class="text-center logo-wrapper">
						<img src="images/logo.png" alt="Anyware Logo">
					</div>
				</div> 
				<div class="panel-body">
					<form class="form-horizontal" method="post" action="<?php echo e(url('login')); ?>">
						<?php echo e(csrf_field()); ?>

						<?php echo $__env->make('errors.form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<div class="form-group">
							<div class="col-xs-12">
								<input class="form-control input-lg" value="<?php echo e(old('username')); ?>" type="text" id="username" name="username" placeholder="Username" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<input class="form-control input-lg" type="password" id="username" name="password" placeholder="Password" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-12">
								<div class="checkbox checkbox-primary">
									<?php if(old('remember')): ?>
										<input id="checkbox-signup" name="remember" type="checkbox" checked>
									<?php else: ?>
										<input id="checkbox-signup" name="remember" type="checkbox">
									<?php endif; ?>
									<label for="checkbox-signup">
										Remember me
									</label>
								</div>
							</div>
						</div>
						<div class="form-group text-center m-t-40">
							<div class="col-xs-12">
								<button class="btn btn-primary btn-lg w-lg waves-effect waves-light" type="submit">Log In</button>
							</div>
						</div>
						<div class="form-group m-t-30">
							<div class="col-sm-7">
								<a href="/forgotpw"><i class="fa fa-lock"></i> Forgot your password?</a>
							</div>
						</div>
					</form>
				</div>
				<footer class="panel-footer">
					<small> &copy; <?php echo e(date('Y')); ?> Anyware.</small>
				</footer>
			</div>					
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>