<!DOCTYPE html>
<?php if($this->ion_auth->logged_in()) {
	$notifikasi	= $this->ion_auth->get_notifikasi_user();
	$admin	  	= $this->ion_auth->is_admin();
	$user_id  	= $this->ion_auth->get_user_id();
	$nama   	= $this->ion_auth->get_name_user();
    $foto	  	= $this->ion_auth->get_foto_user();
}

?>
 

<html>
<head>
    <meta charset="UTF-8">
    <title>MRP</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="shortcut icon" href="<?php echo $themes_url."img" ; ?>">

    <!-- global css -->
    <link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>css/app.css"/>
    <!-- end of global css -->
    
	<!--page level css -->
	<link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>css/custom.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>css/custom_css/skins/skin-blue-gray.css" id="skin"/>
	<link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>css/formelements.css">
	<link rel="stylesheet" href="<?php echo $themes_url; ?>vendors/iCheck/css/all.css"/>
	<link rel="stylesheet" href="<?php echo $themes_url; ?>vendors/iCheck/css/line/line.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>vendors/simple-line-icons/css/simple-line-icons.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>bootstrap-datetimepicker-master/build/css/bootstrap-datetimepicker.min.css">

	<!-- DataTable -->
	<link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>css/custom_css/responsive_datatables.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>vendors/datatables/css/dataTables.bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>vendors/datatablesmark.js/css/datatables.mark.min.css"/>
	
	<!-- File Input -->
	<link href="<?php echo $themes_url; ?>vendors/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>css/formelements.css">

	<!-- Airdate picker css -->
	<link href="<?php echo $themes_url; ?>vendors/airdatepicker/css/datepicker.min.css" rel="stylesheet" type="text/css">
	
	<!-- Select 2 -->
    <link href="<?php echo $themes_url; ?>vendors/bootstrap-multiselect/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $themes_url; ?>vendors/select2/css/select2.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $themes_url; ?>vendors/select2/css/select2-bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $themes_url; ?>vendors/selectize/css/selectize.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $themes_url; ?>vendors/selectric/css/selectric.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $themes_url; ?>vendors/selectize/css/selectize.bootstrap3.css" rel="stylesheet" type="text/css">
	
    <!-- Bootstrap Wizard 2 -->
    <link href="<?php echo $themes_url; ?>css/custom_css/wizard.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>css/custom_css/bootstrap_tables.css">
	<link rel="stylesheet" href="<?php echo $themes_url; ?>vendors/bootstrap-table/css/bootstrap-table.min.css">

	<!-- end of page level css -->
	<script src="<?php echo $themes_url; ?>js/jquery.min.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $themes_url; ?>css/custom.css">
    <link href="<?php echo $themes_url; ?>vendors/hover/css/hover-min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $themes_url; ?>vendors/laddabootstrap/css/ladda-themeless.min.css">
    <link href="<?php echo $themes_url; ?>css/buttons_sass.css" rel="stylesheet">
    <link href="<?php echo $themes_url; ?>css/advbuttons.css" rel="stylesheet">


    <!-- <link href="<?php echo $themes_url; ?>vendors/sweetalert2/css/sweetalert2.min.css" rel="stylesheet"> -->
    <script src="<?php echo $themes_url; ?>vendors/sweetalert2/sweetalert2.all.min.js" type="text/javascript"></script>
    
    
    
</head>

<body class="skin-default">
    <div class="preloader">
        <div class="loader_img"><img src="<?php echo $themes_url; ?>img/loader.gif" alt="loading..." height="64" width="64"></div>
    </div>
    <!-- header logo: style can be found in header-->
    <header class="header">
        <nav class="navbar navbar-static-top" role="navigation">
            <a href="#" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Admin Panel<!-- <img src="<?php echo $themes_url."/img/namakbb.PNG"; ?>" style="width:220px;height:34px" alt="logo"/> -->
            </a>
            <!-- Header Navbar: style can be found in header-->
            <!-- Sidebar toggle button-->
            <!-- Sidebar toggle button-->
            <div>
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button"> 
					<i class="fa fa-fw ti-menu"></i>
                </a>
            </div>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <?php if($user_id != 0 || $user_id != "") { ?>
                    <li class="dropdown messages-menu">
                       
                    </li>
                    <?php } ?>
                    <!--rightside toggle-->
                    <!-- <li>
                        <a href="#" class="dropdown-toggle toggle-right">
                            <i class="fa fa-fw ti-view-list black"></i>
                            <span class="label label-danger">asa</span>
                        </a>
                    </li> -->
                    <!-- User Account: style can be found in dropdown-->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle padding-user" data-toggle="dropdown">
							<?php $ava = (isset($foto) && $foto != "") ? $foto : "avatar.png"; ?>
                            <img src="<?php echo base_url('themes/hr/img/'.$ava); ?>" width="35" class="img-circle img-responsive pull-left"
                            height="35" alt="User Image">
                            <div class="riot">
                                <div>
									<span>
                                        <i class="caret"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?php if(is_null($foto)){echo base_url('themes/hr/img/'.$ava);}
                                else{ echo base_url('themes/hr/img/'.$foto); }
                                 ?>" class="img-circle" alt="User Image">
                                <p> <?php echo $nama[0]; ?></p>
                            </li>
                            <!-- Menu Body -->
                            <?php if($user_id != 0 || $user_id != "") {?>
                            <!-- <li class="p-t-3">
                                <a href="<?php echo site_url('personalia/detail_karyawan?id='.$user_id); ?>">
                                    <i class="fa fa-fw ti-user"></i> Profile <?php echo $nama[0]; ?>
                                </a>
                            </li> -->
                            <li role="presentation"></li>
                            <!-- <li>
                                <a href="<?php echo site_url('personalia/account_setting?id='.$user_id); ?>">
                                    <i class="fa fa-fw ti-settings"></i> Account Settings
                                </a>
                            </li> -->
                            <?php  }else{ ?>
                                <br>
                               <!--  <li>
                                    <a href="<?php echo site_url('calon_pegawai/account_setting'); ?>">
                                        <i class="fa fa-fw ti-settings"></i> Account Settings
                                    </a>
                                </li> -->
                            <?php } ?>
                            <li role="presentation" class="divider"></li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo site_url('auth/changepass'); ?>">
                                        <i class="fa fa-fw ti-lock"></i>
                                        ChPass
                                    </a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo site_url('auth/logout'); ?>">
                                        <i class="fa fa-fw ti-shift-right"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>