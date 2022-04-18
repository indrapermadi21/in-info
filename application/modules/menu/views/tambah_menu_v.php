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
			<!--main content-->
			<form id="form-validation-menu" action="" method="POST" class="form-horizontal">
				<div class="form-group">
					<label class="col-md-3 control-label" for="val-parent">
						Parent Menu
						<span class="text-danger">*</span>
					</label>
					<div class="col-md-8">
						<select class="form-control select2" id="parent" name="parent_id" style="width:100%;">
							<option value="0">Pilih Parent</option>
							<?php foreach ($data_parent as $parent) {
								echo "<option value='" . $parent['idmenu'] . "'>" . $parent['nama_menu'] . "</option>";
							} ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label" for="nama_menu	">
						Nama Menu
						<span class="text-danger">*</span>
					</label>
					<div class="col-md-8">
						<input type="text" id="nama_menu" name="nama_menu" class="form-control" placeholder="Enter your nama menu">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label" for="url	">
						Url
						<span class="text-danger">*</span>
					</label>
					<div class="col-md-8">
						<input type="text" id="url" name="url" class="form-control" placeholder="Enter your url">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label" for="status">
						Status
						<span class="text-danger">*</span>
					</label>
					<div class="col-md-8">
						<label>
							<input type="radio" name="status" value="1" class="square-blue" checked>
						</label>
						<label class="m-l-10">
							Active
						</label>
						<label>
							<input type="radio" name="status" value="0" class="square-blue">
						</label>
						<label class="m-l-10">
							Not Active
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label" for="icon">
						Icon
						<span class="text-danger">*</span>
					</label>
					<div class="col-md-8">
						<input type="text" id="icon" name="icon" class="form-control" placeholder="fa fa-contoh (contoh : user)">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label" for="sequence">
						Urutan Menu
						<span class="text-danger">*</span>
					</label>
					<div class="col-md-8">
						<select class="form-control select2" id="sequence" name="sequence" style="width:100%;">
							<option value="0">Pilih Urutan</option>
							<?php for ($i = 1; $i <= 10; $i++) {
								echo "<option value='" . $i . "'>" . $i . "</option>";
							} ?>
						</select>
					</div>
				</div>
				<div class="row">
					<hr>
				</div>
				<div class="form-group form-actions">
					<div class="pull-right">
						<div class="col-md-12">
							<button type="submit" name="simpan" value="simpan" class="btn btn-effect-ripple btn-primary">Simpan</button>
							<button type="reset" class="btn btn-effect-ripple btn-default reset_btn">Reset</button>
						</div>
					</div>
				</div>
			</form>

		</div>
</section>

<script>
	$('#notifications').slideDown('slow').delay(3500).slideUp('slow');
</script>

<script>
	$(document).ready(function() {
		$('.select2').select2({
			theme: 'bootstrap4'
		});

		$('#form-validation-menu').bootstrapValidator({
			fields: {
				parent: {
					validators: {
						notEmpty: {
							message: 'The parent is required and cannot be empty'
						}
					}
				},
				nama_menu: {
					validators: {
						notEmpty: {
							message: 'The nama_menu is required and cannot be empty'
						}
					}
				},
				url: {
					validators: {

						notEmpty: {
							message: 'The url is required and cannot be empty'
						}
					}
				},
				icon: {
					validators: {
						notEmpty: {
							message: 'The icon is required and cannot be empty'
						}
					}
				},
				sequence: {
					validators: {
						notEmpty: {
							message: 'The secuence is required and cannot be empty'
						}
					}
				},
			},
		}).on('reset', function(event) {
			$('#form-validation-menu').data('bootstrapValidator').resetForm();
		});

		$('#terms').on('ifChanged', function(event) {
			$('#form-validation-menu').bootstrapValidator('revalidateField', $('#terms'));
		});
		$('.reset_btn').on('click', function() {
			var icheckbox = $('.custom_icheck');
			var radiobox = $('.custom_radio');
			icheckbox.prop('defaultChecked') == false ? icheckbox.iCheck('uncheck') : icheckbox.iCheck('check').iCheck('update');
			radiobox.prop('defaultChecked') == false ? radiobox.iCheck('uncheck') : radiobox.iCheck('check').iCheck('update');
		});
	});
</script>