<!DOCTYPE html>
<html>

<head>
    <title>Finance</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?php echo base_url($themes_url.'img/favicon.ico'); ?>"/>
    <!-- Bootstrap -->
    <link href="<?php echo base_url($themes_url.'css/bootstrap.min.css'); ?>" rel="stylesheet">
    <!-- end of bootstrap -->
    <!--page level css -->
    <link type="text/css" href="<?php echo base_url($themes_url.'vendors/themify/css/themify-icons.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo base_url($themes_url.'vendors/iCheck/css/all.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url($themes_url.'vendors/bootstrapvalidator/css/bootstrapValidator.min.css'); ?>" rel="stylesheet"/>
    <link href="<?php echo base_url($themes_url.'css/login.css'); ?>" rel="stylesheet">
    <!--end page level css-->
</head>

<body id="sign-in">
<div class="preloader">
    <div class="loader_img"><img src="<?php echo base_url($themes_url.'img/loader.gif'); ?>" alt="loading..." height="64" width="64"></div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1 login-form">
            <div class="panel-header">
                <h2 class="text-center">
                    <img src="<?php echo base_url($themes_url.'img/nippon_p.png'); ?>" style="width:260px;height:80px;border:0;" alt="Logo">
                </h2>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <form action="<?php echo site_url('user/login'); ?>" id="authentication" method="post" class="login_validator">
                            <div class="form-group">
                                <label for="email" class="sr-only"> Email</label>
                                <input type="text" class="form-control  form-control-lg" id="email" name="username"
                                       placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Kirim Reset Password" class="btn btn-primary btn-block"/>
                            </div>
                            <p>
                            	<a href="<?php echo site_url('user/'); ?>" id="login"> Login </a>
                            </p>
	
														<p>
                            	Belum punya akun ? <a href="<?php echo site_url('user/reg'); ?>">Daftar sekarang</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="panel-header">
                <p class="text-center">&copy; 2018. PT. Nippon Shokubai Indonesia</p>
            </div>              
        </div>
    </div>
</div>
<!-- global js -->
<script src="<?php echo base_url($themes_url.'js/jquery.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url($themes_url.'js/bootstrap.min.js'); ?>" type="text/javascript"></script>
<!-- end of global js -->
<!-- page level js -->
<script type="text/javascript" src="<?php echo base_url($themes_url.'vendors/iCheck/js/icheck.js'); ?>"></script>
<script src="<?php echo base_url($themes_url.'vendors/bootstrapvalidator/js/bootstrapValidator.min.js'); ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url($themes_url.'js/custom_js/login.js'); ?>"></script>
<!-- end of page level js -->
</body>

</html>
