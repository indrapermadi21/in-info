<script>
	$(document).ready(function() {
		$("#group_id").on('change', function() {
			$("#btn_select_group").click();
		});

		$('input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			radioClass: 'iradio_square-blue',
			increaseArea: '20%' // optional
		});
	})
</script>
<section class="content">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title"><?php echo lang('edit_user_heading'); ?></h3>

			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
					<i class="fas fa-minus"></i>
				</button>
				<button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
					<i class="fas fa-times"></i>
				</button>
			</div>
		</div>

		<?php if (!empty($message)) : ?>
			<div class="row">
				<div class="col-xs-12">
					<div id="notifications">
						<div class="alert alert-warning fade in">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<?php echo $message; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
		<div class="card-body">
			<?php echo form_open(uri_string(), array('class' => 'form-horizontal')); ?>
			<div class="form-group">
				<?php
				// if($identity_column!=='email') {
				?>
				<label class="col-md-3 control-label" for="identify">
					<?php echo lang('create_user_identity_label', 'identify'); ?>
					<span class="text-danger">*</span>
				</label>
				<div class="col-md-8">
					<p><?php echo form_input($identify, $identify, array('id' => 'identify', 'class' => 'form-control', 'name' => 'identify', 'type' => 'text', 'readonly' => 'true')); ?></p>
				</div>
				<?php
				// }
				?>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="first_name">
					<?php echo lang('edit_user_fname_label', 'first_name'); ?>
				</label>
				<div class="col-md-8">
					<p><?php echo form_input($first_name, $first_name, array('class' => 'form-control', 'id' => 'first_name', 'name' => 'first_name', 'type' => 'text')); ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="password">
					<?php echo lang('edit_user_password_label', 'password'); ?>
				</label>
				<div class="col-md-8">
					<p><?php echo form_input($password, '', array('class' => 'form-control', 'id' => 'password', 'name' => 'password', 'type' => 'text')); ?></p>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label" for="group_name">
					<?php echo lang('edit_user_password_confirm_label', 'password_confirm'); ?>
				</label>
				<div class="col-md-8">
					<p><?php echo form_input($password_confirm, '', array('class' => 'form-control', 'id' => 'password_confirm', 'name' => 'password_confirm', 'type' => 'text')); ?></p>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-8 col-md-offset-3">
					<?php if ($this->ion_auth->is_admin()) : ?>
						<h3><?php echo lang('edit_user_groups_heading'); ?></h3>
						<?php foreach ($groups as $group) : ?>
							<label class="checkbox">
								<?php
								$gID = $group['id'];
								$checked = null;
								$item = null;
								foreach ($currentGroups as $grp) {
									if ($gID == $grp->id) {
										$checked = ' checked="checked"';
										break;
									}
								}
								?>
								<input type="radio" name="groups[]" value="<?php echo $group['id']; ?>" <?php echo $checked; ?>>
								<?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
							</label>
						<?php endforeach ?>

					<?php endif ?>
				</div>
			</div>
			<?php echo form_hidden('id', $user->id); ?>
			<?php echo form_hidden($csrf); ?>
			<div class="row">
				<hr>
			</div>
			<div class="form-group">
				<div class="col-md-8 col-md-offset-3">
					<button class="btn btn-primary" type="submit" id="btn_submit" name="btn_submit" value="Save">Edit User</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div><!-- /.col -->
	</div>
	<!-- /.card-body -->
	</div>
</section>

<script>
	$('#notifications').slideDown('slow').delay(3500).slideUp('slow');
</script>