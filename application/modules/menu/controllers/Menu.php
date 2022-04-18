<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {
	public $group_menu;
	/**
	* Constructor
	* Controller initialization. Load model, library, etc.
	*/
	function __construct() 	{
		parent::__construct();
		$this->load->model('menu_model');
		$this->load->model('auth/User_model');
	}

	/**
	* Display halaman index
	*/	 
	function index()	{
		$themes_url = 'themes/hr/';
		$data['themes_url'] = base_url($themes_url); 	
		
		
		$this->template->load('maintemplate', 'menu/views/index');
		redirect('menu/edit');
	}
	/**
	* Display edit form
	* 
	*/	public function tambah()
	{
		$themes_url = 'themes/hr/';
		$data['themes_url'] = base_url($themes_url); 	
		
		$data['data_parent'] = $this->menu_model->get_id_menu();
		
		
		$user_id = $this->ion_auth->get_user_id();
		if (empty($user_id)) {
			show_error('Login please', 401);
		}
		
		$pesan = "";
		// $iconx = "menu-icon";
		$icony	= $this->input->post('icon');
		// $iconz = "fa-lg fa-fw";
		
		$simpan = $this->input->post('simpan');
		if($simpan != ""){
			$parentx = $this->input->post('parent_id');
			if($parentx == "" || $parentx == NULL){$parent = 0;}
			$menu 	= $this->input->post('nama_menu');
			$url 	= $this->input->post('url');
			$status = $this->input->post('status');
			
			$icon	= $icony;
			$seq	= $this->input->post('sequence');
			
			$insert = $this->menu_model->insert_menu($parentx,$menu,$url,$status,$icon,$seq);
			if($insert['code'] == 1){
				redirect('menu');
			}else{
				$pesan = "Data gagal disimpan, Silahkan coba kembali !!!";
			}
		}
		$data['pesan'] = $pesan;

		$this->template->load('maintemplate','menu/views/tambah_menu_v',$data);
	}
	
	public function edit() 
	{
		$themes_url = 'themes/hr/';
		$data['themes_url'] = base_url($themes_url); 	
		
		
		// check user login
		$user_id = $this->ion_auth->get_user_id();
		if (empty($user_id)) {
			show_error('Login please', 401);
		}
		
		// get groups for select box items
		$ion_groups = $this->ion_auth->groups()->result_array();
		foreach ($ion_groups as $k => $v) {
			$groups[] = array('id' => $v['id'], 'group' => $v['name'], 'description' => $v['description']);
		}	
		
		// if change group button is clicked, set group_id accordingly
		if ($this->input->post('btn_select_group') != FALSE) {
			$group_id = $this->input->post('group_id'); // role from select box
		} else {
			$group_id = 1; // default group 
		}
		
		// if save button is clicked
		if ($this->input->post('btn_submit') != FALSE) {
			$group_id = $this->input->post('group_id'); // from select box
			$menu_id = $this->input->post('menu_id'); // array of selected menu
			if ($menu_id != FALSE) {
				foreach ($menu_id as $id) {
					$batch_data[] = array('menu_id' => $id, 'group_id' => $group_id);
				}
			} else {
				$batch_data = array();
			}
			$save_result = $this->menu_model->save_menu($batch_data, $group_id);
			if (!$save_result) {
				$data['errors'] = 'Save Failed.';
			}
		}
		
		// get menu by group id for checked menu
		$group_menu = $this->menu_model->get_menu_by_group($group_id);
		
		// set property group_menu for building menu
		$this->group_menu = $group_menu;

		// all menu for check box items, 
		// ATTENTION: $this->_build_menu MUST be called after setting $this->group_menu
		$all_menu = $this->menu_model->get_all_menu();
		$data['menu_html'] = $this->_build_menu(0, $all_menu);
		// after all done, set template vars
		$data['groups'] = $groups;
		$data['group_id'] = $group_id;

		// render template/view
		$this->template->load('maintemplate', 'menu/views/edit', $data);
	}
	
	function _build_menu($parent, $menu) 
	{
		$themes_url = 'themes/hr/';
		$data['themes_url'] = base_url($themes_url); 	
		
		
		$html = "";
		if (isset($menu['parents'][$parent])) {
			$html .= '<ul style="list-style:none">';
			foreach ($menu['parents'][$parent] as $itemId) {
				if (!isset($menu['parents'][$itemId])) {
					if ($this->is_menu_in_group($menu['items'][$itemId]['id'], $this->group_menu))
						$checked = 'checked';
					else
						$checked = '';
					//$html .= "<li>\n  <a href='".$menu['items'][$itemId]['link']."'>".$menu['items'][$itemId]['label']."</a>\n</li> \n";
					$html .=
							'<li>       
					<div class="checkbox icheck">
						<label> 
							<input name="menu_id[]" type="checkbox" value="' . $menu['items'][$itemId]['id'] . '" ' . $checked . '> ' . $menu['items'][$itemId]['nama_menu']
							. '</label>
					</div>
                  </li>';
				}
				if (isset($menu['parents'][$itemId])) {
					if ($this->is_menu_in_group($menu['items'][$itemId]['id'], $this->group_menu))
						$checked = 'checked';
					else
						$checked = '';
					//$html .= "<li>\n  <a href='".$menu['items'][$itemId]['link']."'>".$menu['items'][$itemId]['label']."</a> \n";
					$html .=
							'<li>
					<div class="checkbox icheck">
						<label>
							<input name="menu_id[]" type="checkbox" value="' . $menu['items'][$itemId]['id'] . '" ' . $checked . '> ' . $menu['items'][$itemId]['nama_menu'] .
							'</label>
					</div>';
					$html .= $this->_build_menu($itemId, $menu);
					$html .= '</li>';
				}
			}
			$html .= '</ul>';
		}
		return $html;
	}

	function is_menu_in_group($menu_id, $group_menu) 	{
		foreach ($group_menu['items'] as $item) {
			if ($menu_id == $item['id']) {
				return true;
			}
		}
		return false;
	}
}
