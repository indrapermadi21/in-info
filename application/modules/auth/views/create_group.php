<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
		<?php echo lang('create_group_heading');?>
		<small><?php echo lang('create_group_subheading');?></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url();?>"><i class="fa fa-desktop"></i> Dashboard</a></li>
		<li><a href="<?php echo base_url();?>menu">Menu</a></li>
		<li class="active">Tambah Group</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel">
				<div class="panel-heading">
					<h3 class="panel-title">
						<i class="fa fa-plus"></i> Tambah Group
					</h3>
					<span class="pull-right">
						<i class="fa fa-fw ti-angle-up clickable"></i>
						<i class="fa fa-fw ti-close removepanel clickable"></i>
					</span>
				</div>
				
				<?php if (!empty($message)): ?> 
				<div class="row">
					<div id="notifications">
						<div class="alert alert-warning fade in">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<?php echo $message;?>
						</div>
					</div>
				</div>
				<?php endif; ?>
				
				<div class="panel-body">
					<div class="col-xs-12">
						<?php echo form_open("auth/create_group",array('class'=>'form-horizontal', 'id'=>'authenticationGroups'));?>
							<div class="form-group">
								<label class="col-md-3 control-label" for="group_name">
									<?php echo lang('create_group_name_label', 'group_name');?>
								</label>
								<div class="col-md-8">
									<p><?php echo form_input($group_name,$group_name,array('class'=>'form-control', 'id'=>'group_name', 'name'=>'group_name', 'type'=>'text'));?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="group_name">
									<?php echo lang('create_group_name_label', 'description');?>
								</label>
								<div class="col-md-8">
									<p><?php echo form_input($description,$description,array('class'=>'form-control', 'id'=>'description', 'name'=>'description', 'type'=>'text'));?></p>
								</div>
							</div>
							<div class="row">
								<hr>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-3">
									<button class="btn btn-primary" type="submit" id="btn_submit" name="btn_submit" value="Save">Tambah Group</button>
								</div>
							</div>
						<?php echo form_close();?>
					</div><!-- /.col -->
				</div><!-- /.panel-body -->
			</div><!-- /.panel -->
		</div><!-- /.col -->
	</div><!-- /.row -->
</section><!-- /.content -->

<script> 
    $('#notifications').slideDown('slow').delay(3500).slideUp('slow');
</script>

<script>
$(document).ready(function () {
	$("#authenticationGroups").bootstrapValidator({
		fields: {
			group_name: {
				validators: {
					notEmpty: {
						message: 'The group name is required and cannot be empty'
					}
				}
			},
			description: {
				validators: {
					notEmpty: {
						message: 'The description is required and cannot be empty'
					}
				}
			}
		},
	}).on('reset', function (event) {
		$('#authenticationGroups').data('bootstrapValidator').resetForm();
	});
});
</script>
