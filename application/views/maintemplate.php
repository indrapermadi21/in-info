<?php
	// include(APPPATH . 'views/asset_url.php');
	include(APPPATH . 'views/header.php');
?>	

    <!-- Main Sidebar Container -->
    <?php include(APPPATH . 'views/menu.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <?php include($template_contents . '.php'); ?>

    </div>
    <!-- /.content-wrapper -->
    <?php include(APPPATH . 'views/footer.php'); ?>
</body>

</html>