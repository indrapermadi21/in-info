<!-- iCheck css -->
<link href="<?php echo $path;?>plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
<!-- iCheck js -->
<script src="<?php echo $path;?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>

<script>
	$(document).ready(function() {
		$("#group_id").on('change', function() {
			$("#btn_select_group").click();
		});
		
        /*
         * this cause btn submit to have false value, so it can't be detected in controller
         * $("#form_edit").on('submit', function() {
			$("#btn_submit").prop('disabled', 'disabled');
		});*/
		
		$('input').iCheck({
		  checkboxClass: 'icheckbox_square-blue',
		  radioClass: 'iradio_square-blue',
		  increaseArea: '20%' // optional
		});
	})
</script>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	Menu
	<small>Edit group's permissions </small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
	<li><a href="<?php echo base_url();?>menu">Menu</a></li>
	<li class="active">Edit</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
	<div class="col-xs-12">
		
	  <div class="box box-primary">
		  
		<div class="box-header">
		  <h3 class="box-title">Permissions Editor</h3>
		</div><!-- /.box-header -->
		
		<?php if ( ! empty($errors) ): ?> 
		<div class="box-body">
			<div class="alert alert-danger alert-dismissable"> 
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> 
				<h4><i class="icon fa fa-ban"></i> Error!</h4> 
				<span class="content">
					<?php echo trim($errors); ?>
				</span>
			</div> 
		</div>
		<?php endif; ?>
		
		<div class="box-body">
			
			<form action="<?php echo base_url();?>menu/edit/" method="post" id="form_edit">
				<div class="form-group">
					<label>User Group</label> 
					<div class="input-group">
						<select id="group_id" name="group_id" class="form-control">
							<?php foreach ($groups as $k => $v) :?>
							<option value="<?php echo $v['id'];?>" <?php if ( isset($group_id) && $group_id == $v['id']) echo 'selected="selected"';?>>
								<?php echo $v['group'];?> - 
								<?php echo $v['description'];?>
							</option>
							<?php endforeach;?>
						</select>
						<span class="input-group-btn">
							<button class="btn btn-primary" type="submit" id="btn_select_group" name="btn_select_group" value="OK"><i class="fa fa-refresh"></i></button>
						</span>
					</div>
				</div>
				
				<?php echo $menu_html;?>

                <br>
				<div class="form-group">
					<button class="btn btn-primary" type="submit" id="btn_submit" name="btn_submit" value="Save"> Save </button>
					<!--<button class="btn btn-lg btn-block btn-success" type="submit" id="btn_submit" name="btn_submit" value="Save">Save</button>-->
				</div>
			</form>
		</div><!-- /.box-body -->
			
	  </div><!-- /.box-primary -->
	</div><!-- /.col -->
  </div><!-- /.row -->
</section><!-- /.content -->
