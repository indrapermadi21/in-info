<?php

class Menu_tree {

	private $menu_data;

	function __construct() {

		$ci = & get_instance();
		// Get logged in user
		$user_id = $ci->ion_auth->get_user_id();
		$ci->load->model('menu/menu_model');
		$this->menu_data = $ci->menu_model->get_menu_by_user($user_id);
		//print_r($this->menu_data);exit();
	}

	function generate_html() {
		
		if (!empty($this->menu_data['parents'])) {
			$min_parent = min(array_keys($this->menu_data['parents']));
			return $this->_build_menu($min_parent, $this->menu_data);
		} else {
			return FALSE;
		}
	}

	private function _build_menu($parent, $menu) {
		$html = '';
		if (isset($menu['parents'][$parent])) {
			//$html .= '<li class="treeview">';
			foreach ($menu['parents'][$parent] as $itemId) {
				if (!isset($menu['parents'][$itemId])) {
					$html .=
							'<li class="menu-dropdown" id="menu">
								<a href="' . base_url() . $menu['items'][$itemId]['url'] . '" >
									<i class="' . $menu['items'][$itemId]['icon'] . '"></i>' .
									'<span>' . $menu['items'][$itemId]['nama_menu'] . '</span>' .
								'</a>
							</li>';
				}
				if (isset($menu['parents'][$itemId])) {

					$html .=
							'<li class="menu-dropdown" id="menu">
								<a href="' . base_url() . $menu['items'][$itemId]['url'] . '" >
									<i class="' . $menu['items'][$itemId]['icon'] . '"></i>' .
									'<span>' . $menu['items'][$itemId]['nama_menu'] . '</span>' .
									'<i class="fa fa-angle-right pull-right"></i>
								</a>
								<ul class="sub-menu">';

					$html .= $this->_build_menu($itemId, $menu);

					$html .= '</ul></li>';
				}
			}
		}
		return $html;
	}
}
?>
<aside class="left-side sidebar-offcanvas">
			<!-- sidebar: style can be found in sidebar-->
			<section class="sidebar">
				<div id="menu" role="navigation">
					<div class="nav_profile">
						<div class="media profile-left">
							<a class="pull-left profile-thumb" href="#">
								<?php $ava = (isset($foto) && $foto != "") ? $foto : "avatar.png"; ?>
								<img src="<?php echo base_url('themes/hr/img/'.$ava); ?>" class="img-circle" alt="User Image">
							</a>
							<div class="content-profile">
								<h4 class="media-heading">
									<?php echo $nama[0]; ?>
								</h4>
								<ul class="icon-list">
								
									
									<li>
										<a href="<?php echo site_url('auth/logout'); ?>">
											<i class="fa fa-fw ti-lock"></i>
										</a>
									</li>
									
								
								</ul>
							</div>
						</div>
					</div>
					<ul class="navigation">
						<li>
							<?php
								$menu_tree = new Menu_tree();
								echo $menu_tree->generate_html();
							?>
						</li>
					</ul>
					<!-- / .navigation -->
				</div>
				<!-- menu -->
			</section>
			<!-- /.sidebar -->
		</aside>
    