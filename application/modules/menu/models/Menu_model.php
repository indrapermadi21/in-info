<?php

/**
 * Description of t_menu_model
 *
 * @author triswan
 */
class Menu_model extends CI_Model
{
	/**
	 * Get t_menu by user id
	 * 
	 * @param int user_id
	 * @return mixed t_menu 
	 */
	function get_menu_by_user($user_id)
	{
		if (empty($user_id)) {
			return FALSE;
		}
		// get groups of logged in user
		$user_groups = $this->ion_auth->get_users_groups($user_id)->result();
		foreach ($user_groups as $group) {
			$group_ids[] = (int) $group->id;
		}
		if (empty($group_ids)) {
			return FALSE;
		}
		$in_sql = implode(',', array_fill(0, count($group_ids), '?'));
		$sql = " SELECT DISTINCT t_menu.id, t_menu.parent, t_menu.url, t_menu.nama_menu, t_menu.status, t_menu.icon, t_menu.sequence FROM t_menu 
					INNER JOIN t_menu_group ON t_menu_group.menu_id = t_menu.id
					WHERE t_menu.status = TRUE 
					AND t_menu_group.group_id IN($in_sql) 
               ORDER BY t_menu.sequence";
		$query = $this->db->query($sql, $group_ids);
		$result = $query->result_array();
		$menu = array(
			'items' => array(),
			'parents' => array()
		);
		// Builds the array lists with data from the t_menu table
		foreach ($result as $items) {
			// Creates entry into items array with current t_menu item id ie. $menu['items'][1]
			$menu['items'][$items['id']] = $items;
			// Creates entry into parents array. Parents array contains a list of all items with children
			$menu['parents'][$items['parent']][] = $items['id'];
		}
		//echo 't_menu: '; var_dump($t_menu);
		return $menu;
	}
	/**
	 * Get menu by user group id
	 * 
	 * @param int $group_id
	 * @return mixed menu 
	 */
	function get_menu_by_group($group_id)
	{
		if (empty($group_id)) {
			return FALSE;
		}
		$sql = " SELECT DISTINCT t_menu.id, t_menu.parent, t_menu.url, t_menu.nama_menu, t_menu.status, t_menu.icon, t_menu.sequence FROM t_menu 
					INNER JOIN t_menu_group ON t_menu_group.menu_id = t_menu.id
					WHERE t_menu.status = TRUE 
						AND t_menu_group.group_id = ?
					ORDER BY t_menu.parent, t_menu.sequence";
		$query = $this->db->query($sql, array($group_id));
		$result = $query->result_array();
		$menu = array(
			'items' => array(),
			'parents' => array()
		);
		// Builds the array lists with data from the t_menu table
		foreach ($result as $items) {
			// Creates entry into items array with current t_menu item id ie. $t_menu['items'][1]
			$menu['items'][$items['id']] = $items;
			// Creates entry into parents array. Parents array contains a list of all items with children
			$menu['parents'][$items['parent']][] = $items['id'];
		}
		//echo 'menu: '; var_dump($menu);
		return $menu;
	}
	/**
	 * Get all t_menu
	 * 
	 * @return array
	 */
	function get_all_menu()
	{
		$sql = "  SELECT t_menu.id, t_menu.parent, t_menu.url, t_menu.nama_menu, t_menu.status, t_menu.icon,  t_menu.sequence FROM t_menu
					WHERE t_menu.status = TRUE
					ORDER BY t_menu.parent, t_menu.sequence";
		$query = $this->db->query($sql);
		$result = $query->result_array();
		$menu = array(
			'items' => array(),
			'parents' => array()
		);
		// Builds the array lists with data from the t_menu table
		foreach ($result as $items) {
			// Creates entry into items array with current t_menu item id ie. $t_menu['items'][1]
			$menu['items'][$items['id']] = $items;
			// Creates entry into parents array. Parents array contains a list of all items with children
			$menu['parents'][$items['parent']][] = $items['id'];
		}
		//echo 't_menu: '; var_dump($t_menu);
		return $menu;
	}
	/**
	 * Save menu for a user group
	 * 
	 * @param array $data
	 * @param int $group_id
	 * @return boolean
	 */
	function save_menu($data, $group_id)
	{
		//var_dump($data);	exit();
		$this->db->trans_start();
		// delete
		$this->db->where('group_id', $group_id);
		$this->db->delete('t_menu_group');
		// insert batch
		if (!empty($data)) {
			$this->db->insert_batch('t_menu_group', $data);
		}

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return true;
		}
	}

	function get_id_menu()
	{
		$sql = "SELECT id AS idmenu,nama_menu FROM t_menu";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	function insert_menu($parent, $menu, $url, $status, $icon, $seq)
	{
		$data = array(
			'parent' => $parent,
			'nama_menu' => $menu,
			'url' => $url,
			'status' => $status,
			'icon' => $icon,
			'sequence' => $seq
		);

		$this->db->insert('t_menu', $data);
		
		if ($this->db->affected_rows() > 0) {
			$data = array(
				'code' => '1'
			);
			return $data;
		} else {
			$data = array(
				'code' => '0'
			);
			return $data;
		}
	}
}
