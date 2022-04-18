<!DOCTYPE html>
<html>
<?php $session_data = $this->session->userdata('logged_in'); ?>
<style>
    .cardtengah {
        box-shadow: 0 30px 30px 20px rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        border-radius: 15px;
        width: 60%;
        height: 60%;
        background: white;

    }
</style>

<html>

<head>

    <title>Verify</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="shortcut icon" href="<?php //echo base_url('assets/'); 
                                            ?> " /> -->
    <!--<link rel="shortcut icon" href="<?php echo 'upload/gambar/' . $session_data['icon']; ?>"/>-->
    <!-- Bootstrap -->
    <link href="<?php echo base_url($folder_themes . 'css/bootstrap.css'); ?>" rel="stylesheet">
    <!-- end of bootstrap -->

    <!--page level css -->
    <link type="text/css" href="<?php echo base_url($folder_themes . 'vendors/themify/css/themify-icons.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url($folder_themes . 'vendors/iCheck/css/all.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url($folder_themes . 'vendors/bootstrapvalidator/css/bootstrapValidator.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url($folder_themes . 'css/login.css'); ?>" rel="stylesheet">
</head>



<body id="sign-in">

    <div class="preloader">

        <div class="loader_img"><img src="<?php echo base_url($folder_themes . 'img/loader.gif'); ?>" alt="loading..." height="64" width="64"></div>

    </div>

    <div class="container">

        <div class="row">

            <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1 login-form">

                <div class="panel-header">

                    <h2 class="text-center">

                        <a href="#"><img src="<?php echo base_url($folder_themes . 'img/login/logo-login.jpeg'); ?>" class="image-back" style="width:100%"></a>

                    </h2>

                </div>

                <div class="panel-body">

                    <div class="row">

                        <div class="col-xd-12">
                            <?php if ($message) { ?>
                                <div id="notifications" class="alert alert-danger text-center" style="height:5%;">
                                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
                                    <p class="alert"><?php echo $message; ?></p>
                                </div>
                            <?php } ?>
                            <?php echo form_open('auth/login', array('method' => 'post', 'id' => 'authenticationLogin', 'class' => 'login_validator')); ?>
                            <div class="form-group has-feedback">
                                <label for="username" class="sr-only"> Username</label>
                                <input type="text" class="form-control  form-control-lg" id="identity" name="identity" placeholder="Username">
                                <?php /*echo form_input($identity, set_value('identity'), array('type' => 'text', 'class' => 'form-control form-control-lg', 'placeholder' => lang('identity')));*/ ?>
                                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <div class="input-group" id="show_hide_password">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password">
                                    <?php /*echo form_input($password, set_value('password'), array('type' => 'password', 'class' => 'form-control form-control-lg', 'placeholder' => lang('password')));*/ ?>
                                    <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->

                                    <!-- <input class="form-control" type="password"> -->
                                    <div class="input-group-addon">
                                        <a href=""><i class="glyphicon glyphicon-eye-close" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <!-- <input type="checkbox" class="form-control form-control-lg" onclick="myFunction()">Show Password -->
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 pull-left">
                                        <label for="terms">
                                            <?php /*<input type="checkbox" name="terms" id="terms">&nbsp; Calon Pegawai</br>*/ ?>
                                            <!-- <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"', 'type="checkbox"'); ?> Remember Me -->
                                        </label>
                                    </div>
                                    <div class="col-md-6 pull-right">

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="tombol" class="btn btn-primary btn-block">Login</button>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
                        <div class="col-md-6 pull-left">
                            <!-- <p><a href="<?php //echo site_url('forgotpass');
                                                ?>" id="forgot" class="forgot"> Lupa Password ?</a></p> -->
                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>


    <!-- global js -->
    <script src="<?php echo base_url($folder_themes . 'js/jquery.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url($folder_themes . 'js/bootstrap.min.js'); ?>" type="text/javascript"></script>
    <!-- end of global js -->

    <script>
        $('#notifications').slideDown('slow').delay(3000).slideUp('slow');
    </script>

    <script>
        $(document).ready(function() {
            $("#authenticationLogin").bootstrapValidator({
                fields: {
                    identity: {
                        validators: {
                            notEmpty: {
                                message: 'The Username is required'
                            },
                            // regexp: {
                            //     regexp: /^\S+@\S{1,}\.\S{1,}$/,
                            //     message: 'Please enter valid email format'
                            // }
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


            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("glyphicon-eye-close");
                    $('#show_hide_password i').removeClass("glyphicon-eye-open");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("glyphicon-eye-close");
                    $('#show_hide_password i').addClass("glyphicon-eye-open");
                }
            });
        });
    </script>

    <!-- page level js -->
    <script type="text/javascript" src="<?php echo site_url($folder_themes . 'vendors/iCheck/js/icheck.js'); ?>"></script>
    <script src="<?php echo site_url($folder_themes . 'vendors/bootstrapvalidator/js/bootstrapValidator.min.js'); ?>" type="text/javascript"></script>
    <script type="text/javascript" src="<?php echo site_url($folder_themes . 'js/custom_js/login.js'); ?>"></script>
    <script src="<?php echo site_url($folder_themes . 'js/custom_js/register.js'); ?>"></script>
    <!-- end of page level js -->

</body>



</html>