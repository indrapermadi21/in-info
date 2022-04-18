<!--page level css -->
<link rel="stylesheet" href="<?php echo $themes_url; ?>css/passtrength/passtrength.css">
<link href="<?php echo $themes_url; ?>vendors/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet">

<!--prettycheckable -->
<link href="<?php echo $themes_url; ?>vendors/prettycheckable/css/prettyCheckable.css" rel="stylesheet" type="text/css"/>
<!-- labelauty -->
<link href="<?php echo $themes_url; ?>vendors/jquerylabel/css/jquery-labelauty.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>css/custom_css/radio_checkbox.css">

<script>
	$(document).ready(function() {
		$("#group_id").on('change', function() {
			$("#btn_select_group").click();
		});
		
		/*$("#form_edit").on('submit', function() {
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
			Tambah User
			<?php /*echo lang('index_heading');*/?>
			<small><?php echo lang('index_subheading');?></small>
		</h1>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo site_url($themes_url,'dashboard');?>">
					<i class="fa fa-fw ti-home"></i> Dashboard
				</a>
			</li>
			<li> <a href="<?php echo site_url('auth');?>">List User</a></li>
			<li> Tambah User </li>
		</ol>
	</section>
	<section class="content">
		<!--main content-->
		<div class="row">
			<div class="col-xs-12">
				<?php if($message != "") { ?>
					<div id="notifications">
						<div class="alert alert-warning fade in">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							<?php echo $message;?>
						</div>
					</div>
				<?php } ?>
				<div class="panel ">
					<div class="panel-heading">
						<h3 class="panel-title">
							<i class="fa fa-fw ti-user"></i> Tambah User
						</h3>
						<span class="pull-right">
								<i class="fa fa-fw ti-angle-up clickable"></i>
								<i class="fa fa-fw ti-close removepanel clickable"></i>
							</span>
					</div>
					<div class="panel-body">
						<?php echo form_open("auth/create_user",array('class'=>'form-horizontal', 'id'=>'authenticationUsers'));?>
							<div class="form-group">
								<?php
									if($identity_column!=='email') {
								?>
									<label class="col-md-3 control-label" for="identify">
									<?php echo lang('create_user_identity_label', 'identify');?>
									<span class="text-danger">*</span>
									</label>
									<div class="col-md-8">
										<p><?php echo form_input($identity,$identity,array('id'=>'identify', 'class'=>'form-control', 'name'=>'identify', 'type'=>'text', 'placeholder'=>'Masukan NIP '));?></p>
									</div>
								<?php
									}
								?>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="firstname">
									Name
									<span class="text-danger">*</span>
								</label>
								<div class="col-md-8">
									<p><?php echo form_input($first_name,$first_name,array('id'=>'first_name', 'class'=>'form-control hapusnama', 'name'=>'first_name', 'type'=>'text', 'placeholder'=>'Masukan nama '));?></p>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-3 control-label" for="email">
									<?php echo lang('create_user_email_label', 'email');?>
									<span class="text-danger">*</span>
								</label>
								<div class="col-md-8">
									<p><?php echo form_input($email,$email,array('id'=>'email', 'class'=>'form-control', 'name'=>'email', 'type'=>'text', 'placeholder'=>'Masukan email'));?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="password">
									<?php echo lang('create_user_password_label', 'password');?>
									<span class="text-danger">*</span>
								</label>
								<div class="col-md-8">
									<p><?php echo form_input($password,$password,array('id'=>'password', 'class'=>'form-control', 'name'=>'password', 'type'=>'text', 'placeholder'=>'Masukan password'));?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="confirmpassword">
									<?php echo lang('create_user_password_confirm_label', 'password_confirm');?>
									<span class="text-danger">*</span>
								</label>
								<div class="col-md-8">
									<p><?php echo form_input($password_confirm,$password_confirm,array('id'=>'confirmpassword', 'class'=>'form-control', 'name'=>'password_confirm', 'type'=>'text', 'placeholder'=>'Konfirmasi Password'));?></p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label">Group Member
									<span class="text-danger">*</span>
								</label>
								<div class="col-md-8">
									<?php if ($this->ion_auth->in_group(array(GROUP_SUPER_ADMIN))): ?>
										<?php foreach ($groups as $group): ?>
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
												<input type="radio" name="groups[]" value="<?php echo $group['id']; ?>"<?php echo $checked; ?>>
												<?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
											</label>
										<?php endforeach ?>

									<?php endif ?>
								</div>
							</div>
							<?php /*<div class="form-group">
								<div class="col-md-8 col-md-offset-3">
									<label class="padding7" for="terms">
										<input type="checkbox" class="custom_icheck" id="terms" name="terms"
											   value="1">&nbsp;&nbsp;I agree to
										<a href="#modal-terms" data-toggle="modal">
											Terms &amp; Conditions
										</a>
									</label>
								</div>
							</div>*/ ?>
							<div class="row">
								<hr>
							</div>
							<div class="form-group form-actions">
								<div class="col-md-8 col-md-offset-3">
									<div class="col-md-2">
										<button type="submit" class="btn btn-primary">Create User</button>
									</div>
									<div class="col-md-2">
										<button type="reset" class="btn btn-effect-ripple btn-default reset_btn">Reset</button>
									</div>
								</div>
							</div>
						<?php echo form_close();?>
					</div>
				</div>
			</div>
			
		</div>
		<div class="background-overlay"></div>
	</section>

	<script> 
    $('#notifications').slideDown('slow').delay(3500).slideUp('slow');
</script>

<script>
$(document).ready(function () {
	$("#authenticationUsers").bootstrapValidator({
		fields: {
			first_name: {
				validators: {
					notEmpty: {
						message: 'The firstname is required and cannot be empty'
					}
				}
			},
			identify: {
				validators: {
					notEmpty: {
						message: 'The username is required and cannot be empty'
					}
				}
			},
			// last_name: {
			// 	validators: {
			// 		notEmpty: {
			// 			message: 'The lastname is required and cannot be empty'
			// 		}
			// 	}
			// },
			// company: {
			// 	validators: {
			// 		notEmpty: {
			// 			message: 'The company is required and cannot be empty'
			// 		}
			// 	}
			// },
			// id_perusahaan: {
			// 	validators: {
			// 		notEmpty: {
			// 			message: 'The id perusahaan is required and cannot be empty'
			// 		}
			// 	}
			// },
			// id_candidate: {
			// 	validators: {
			// 		notEmpty: {
			// 			message: 'The id candidate is required and cannot be empty'
			// 		}
			// 	}
			// },
			// id_employee: {
			// 	validators: {
			// 		notEmpty: {
			// 			message: 'The id employee is required and cannot be empty'
			// 		}
			// 	}
			// },
			email: {
				validators: {
					notEmpty: {
						message: 'The Email is required'
					},
					regexp: {
						regexp: /^\S+@\S{1,}\.\S{1,}$/,
						message: 'Please enter valid email format'
					}
				}
			},
			password: {
                validators: {
                    notEmpty: {
                        message: 'Please provide a password'
                    }
                }
            },
			password_confirm: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and can\'t be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'Please enter the password same as above'
                    }
                }
            },
			phone: {
				validators: {
					notEmpty: {
						message: 'The phone is required and cannot be empty'
					}
				}
			}
		},
	}).on('reset', function (event) {
		// $('#hapusnama').clear();
		//document.getElementsByName('hapusnama').val("");
		
		$('#authenticationUsers').data('bootstrapValidator').resetForm();
		
	});
	
	$('#terms').on('ifChanged', function (event) {

		$('#authenticationUsers').bootstrapValidator('revalidateField', $('#terms'));
	});
	$('.reset_btn').on('click', function () {
		var icheckbox = $('.custom_icheck');
		var radiobox = $('.custom_radio');

		icheckbox.prop('defaultChecked') == false ? icheckbox.iCheck('uncheck') : icheckbox.iCheck('check').iCheck('update');
		radiobox.prop('defaultChecked') == false ? radiobox.iCheck('uncheck') : radiobox.iCheck('check').iCheck('update');

	});
});
</script>

<!-- begining of page level js -->
<script type="text/javascript" src="<?php echo $themes_url; ?>vendors/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?php echo $themes_url; ?>vendors/bootstrap-maxlength/js/bootstrap-maxlength.js"></script>
<script type="text/javascript" src="<?php echo $themes_url; ?>vendors/sweetalert2/js/sweetalert2.min.js"></script>
<script type="text/javascript" src="<?php echo $themes_url; ?>vendors/card/jquery.card.js"></script>
<script type="text/javascript" src="<?php echo $themes_url; ?>vendors/iCheck/js/icheck.js"></script>
<script src="<?php echo $themes_url; ?>js/passtrength/passtrength.js"></script>
<script type="text/javascript" src="<?php echo $themes_url; ?>js/custom_js/form2.js"></script>
<script type="text/javascript" src="<?php echo $themes_url; ?>js/custom_js/form3.js"></script>
<!-- end of page level js -->