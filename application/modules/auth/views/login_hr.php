<!DOCTYPE html>
<html>
<?php $session_data = $this->session->userdata('logged_in'); 
	$nama_perusahaan = ""; $logo_perusahaan = ""; $ico_perusahaan = "";
	if (sizeof($site_corp)>0) {
		$nama_perusahaan = $site_corp[0]["nama_perusahaan"];
		$logo_perusahaan = $site_corp[0]["logo"];
		$ico_perusahaan = $site_corp[0]["icon"];
} ?>
<style>
    .cardtengah{
        box-shadow: 0 30px 30px 20px rgba(0,0,0,0.2);
        transition: 0.3s;
        border-radius: 15px;
        width: 60%;
        height: 60%;
       
        background: white;
       
    }
</style>
<head>
    <title>Human Resource</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo base_url('assets/'.$ico_perusahaan);?> "/> 
    <!--<link rel="shortcut icon" href="<?php echo 'upload/gambar/'.$session_data['icon'];?>"/>-->
    <!-- Bootstrap -->
    <link href="<?php echo base_url($folder_themes.'css/bootstrap.css'); ?>" rel="stylesheet">
    <!-- end of bootstrap -->
	
    <!--page level css -->
    <link type="text/css" href="<?php echo base_url($folder_themes.'vendors/themify/css/themify-icons.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo base_url($folder_themes.'vendors/iCheck/css/all.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url($folder_themes.'vendors/bootstrapvalidator/css/bootstrapValidator.min.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo base_url($folder_themes.'css/login.css'); ?>" rel="stylesheet">
    <!--end page level css-->
	<?php /*
		header('Last-Modified:'.  gmdate('D, d M Y H:i:s').'GMT');
		header('Cache-Control: no-store, no-cache, must-revalidate');
		header('Cache-Control: post-check=0, pre-check=0',false);
		header('Pragma: no-cache'); 
	*/ ?>
	
	
</head>

<body id="sign-in">
<div class="preloader">
    <div class="loader_img"><img src="<?php echo base_url($folder_themes.'img/loader.gif'); ?>" alt="loading..." height="64" width="64"></div>
</div>
<div class="container">
	<div class="box-login">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-8 box-background">
					<a href="#"><img src="<?php echo base_url($folder_themes.'img/login/login.png'); ?>" class="image-back" style="width:70%"></a>
				</div>
				<div class="col-md-4 login-form">
					<div class="panel-header">
						<h2 class="text-center">
							<a href="<?php echo "/"; ?>"><img src="<?php echo base_url("assets/".$logo_perusahaan); ?>" alt="Logo" style="width:40%"></a>
						</h2>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12">
								<?php if($message){ ?>
									<div id="notifications" class="alert alert-danger text-center" style="height:10%;">
										<i class="fa fa-info-circle icon_id"></i>
										<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
										<p class="alert"><?php echo $message;?></p>
									</div>
								<?php } ?>
								<?php echo form_open('auth/login',array('method' => 'post', 'id' => 'authenticationLogin', 'class' => 'login_validator'));?>
									<div class="form-group has-feedback">
										<label for="username" class="sr-only"> Email</label>
										<input type="text" class="form-control  form-control-lg" id="identity" name="identity" placeholder="Email">
										<?php /*echo form_input($identity, set_value('identity'), array('type' => 'text', 'class' => 'form-control form-control-lg', 'placeholder' => lang('identity')));*/ ?>
										<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
									</div>
									<div class="form-group has-feedback">
										<label for="password" class="sr-only">Password</label>
										<input type="password"  class="form-control form-control-lg" id="password" name="password" placeholder="Password">
										<?php /*echo form_input($password, set_value('password'), array('type' => 'password', 'class' => 'form-control form-control-lg', 'placeholder' => lang('password')));*/ ?>
										<span class="glyphicon glyphicon-lock form-control-feedback"></span>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6 pull-left">
												<label for="terms">
													<?php /*<input type="checkbox" name="terms" id="terms">&nbsp; Calon Pegawai</br>*/ ?>
													<?php echo form_checkbox('remember', '1', FALSE, 'id="remember"', 'type="checkbox"');?> Remember Me
												</label>
											</div>
											<div class="col-md-6 pull-right">
												<label for="terms">
													<?php echo form_checkbox('calon', '2', FALSE, 'id="calon"', 'type="checkbox"');?> Calon Pegawai
												</label>
											</div>
										</div>
		                            </div>
									<div class="form-group">
										<button type="submit" name="tombol" class="btn btn-primary btn-block">Login</button>
									</div>
									
								<?php echo form_close(); ?>
							</div>
							<div class="col-md-6 pull-left">
								<p><a href="<?php echo site_url('forgotpass');?>" id="forgot" class="forgot"> Lupa Password ?</a></p>
							</div>
							<div class="col-md-6 pull-right">
								<p><a href="<?php echo site_url('register'); ?>" id="forgot" class="forgot">Daftar Calon Pegawai</a></p>
							</div>
						</div>
					</div>
					<div class="panel-header">
						<p class="text-center">&copy; 2018. <?php echo $nama_perusahaan; ?></p>
					</div>            
				</div>
			</div>
		</div>
	</div>
</div>

<!-- global js -->
<script src="<?php echo base_url($folder_themes.'js/jquery.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($folder_themes.'js/bootstrap.min.js'); ?>" type="text/javascript"></script>
<!-- end of global js -->

<script>   
    $('#notifications').slideDown('slow').delay(2500).slideUp('slow');
</script>

<script>
$(document).ready(function () {
	$("#authenticationLogin").bootstrapValidator({
		fields: {
			identity: {
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
						message: 'Password is required'
					}
				}
			}
		}
	});
});
</script>

<!-- page level js -->
<script type="text/javascript" src="<?php echo site_url($folder_themes.'vendors/iCheck/js/icheck.js'); ?>"></script>
<script src="<?php echo site_url($folder_themes.'vendors/bootstrapvalidator/js/bootstrapValidator.min.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo site_url($folder_themes.'js/custom_js/login.js'); ?>"></script>
<script src="<?php echo site_url($folder_themes.'js/custom_js/register.js'); ?>"></script>
<!-- end of page level js -->
</body>

</html>
