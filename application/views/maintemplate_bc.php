<?php
	include(APPPATH . 'views/asset_url.php');
	include(APPPATH . 'views/header.php');
?>	

	<!-- Left side column. contains the logo and sidebar -->
	<div class="wrapper row-offcanvas row-offcanvas-left">
		<?php include(APPPATH . 'views/menu.php');?>

		<!-- Content Wrapper. Contains page content -->
		<aside class="right-side">
			<?php include($template_contents.'.php');?>
			
		</aside>
		
		<!-- /.aside-right -->
		<?php include(APPPATH . 'views/footer.php');?>
		
	</div>
	</body>
</html>
