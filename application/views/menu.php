<?php

class Menu_tree
{

	private $menu_data;

	function __construct()
	{

		$ci = &get_instance();
		// Get logged in user
		$user_id = $ci->ion_auth->get_user_id();
		$ci->load->model('menu/menu_model');
		$this->menu_data = $ci->menu_model->get_menu_by_user($user_id);
		// print_r($this->menu_data);exit();
	}

	function generate_html()
	{

		if (!empty($this->menu_data['parents'])) {
			$min_parent = min(array_keys($this->menu_data['parents']));
			return $this->_build_menu($min_parent, $this->menu_data);
		} else {
			return FALSE;
		}
	}

	private function _build_menu($parent, $menu)
	{
		$html = '';
		if (isset($menu['parents'][$parent])) {
			//$html .= '<li class="treeview">';
			foreach ($menu['parents'][$parent] as $itemId) {
				if (!isset($menu['parents'][$itemId])) {
					$html .=
						'<li class="nav-item" id="menu">
							<a href="' . base_url() . $menu['items'][$itemId]['url'] . '" class="nav-link">
							<i class="' . $menu['items'][$itemId]['icon'] . '"></i>' .
							'<p>' . $menu['items'][$itemId]['nama_menu'] . '</p>' .
							'</a>
						</li>';
				}
				if (isset($menu['parents'][$itemId])) {

					$html .=
						'<li class="nav-item" id="menu">
							<a href="' . base_url() . $menu['items'][$itemId]['url'] . '" class="nav-link">
							<i class="' . $menu['items'][$itemId]['icon'] . '"></i>' .
							'<p>'
								. $menu['items'][$itemId]['nama_menu'] .
								'<i class="right fas fa-angle-left"></i>
							</p>
							
							</a>
						<ul class="nav nav-treeview">';

					$html .= $this->_build_menu($itemId, $menu);

					$html .= '</ul></li>';
				}
			}
		}
		return $html;
	}
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="index3.html" class="brand-link">
		<img src="<?= base_url('assets/dist/img/AdminLTELogo.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">Inventory</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="<?= base_url('assets/dist/img/user2-160x160.jpg')?>" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="#" class="d-block">Admin</a>
			</div>
		</div>

		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
				<?php
				$menu_tree = new Menu_tree();
				echo $menu_tree->generate_html();
				?>
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>