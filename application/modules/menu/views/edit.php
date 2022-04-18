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
<br>
<section class="content">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Menu</h3>

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
			<form action="<?php echo site_url(); ?>menu/edit/" method="post" id="form_edit">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label">User Group</label>
					<div class="col-sm-5">
						<select id="group_id" name="group_id" class="form-control select2">
							<?php foreach ($groups as $k => $v) : ?>
								<option value="<?php echo $v['id']; ?>" <?php if (isset($group_id) && $group_id == $v['id']) echo 'selected="selected"'; ?>>
									<?php echo $v['group']; ?> -
									<?php echo $v['description']; ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
					<div class="col-sm-2">
						<button class="btn btn-primary" type="submit" id="btn_select_group" name="btn_select_group" value="OK"><i class="fa fa-refresh"></i></button>
					</div>
				</div>
				<div class="row">
					<hr>
				</div>
				<?php echo $menu_html; ?>
				<div class="row">
					<hr>
				</div>
				<div class="form-group">
					<button class="btn btn-primary" type="submit" id="btn_submit" name="btn_submit" value="Save"> Save </button>
					<?php /*<button class="btn btn-lg btn-block btn-success" type="submit" id="btn_submit" name="btn_submit" value="Save">Save</button>*/ ?>
				</div>
			</form>

</section><!-- /.content -->
<script>
	$(document).ready(function() {
		$('.select2').select2({
			theme: 'bootstrap4'
		});
	});
</script>