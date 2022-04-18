<section class="content">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title"><?php echo lang('deactivate_heading'); ?></h3>

			<div class="card-tools">
				<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
					<i class="fas fa-minus"></i>
				</button>
				<button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
					<i class="fas fa-times"></i>
				</button>
			</div>
		</div>
		<div class="card-body">
			<p><?php echo sprintf(lang('deactivate_subheading'), $user->username); ?> ?</p>
			<?php echo form_open("auth/deactivate/" . $user->id); ?>
			<div class="form-group">
				<p>
					<?php echo lang('deactivate_confirm_y_label', 'confirm'); ?>
					<input type="radio" name="confirm" value="yes" checked="checked" />
				</p>
			</div>
			<div class="form-group">
				<p><?php echo lang('deactivate_confirm_n_label', 'confirm'); ?>
					<input type="radio" name="confirm" value="no" />
				</p>
			</div>
			<?php echo form_hidden($csrf); ?>
			<?php echo form_hidden(array('id' => $user->id)); ?>
			<div class="row">
				<hr>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<button class="btn btn-primary" type="submit" id="btn_submit" name="btn_submit" value="Save">Submit</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
		<!-- /.card-body -->
	</div>
</section>