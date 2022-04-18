<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class General {

	public function session_check()
	{
		$CI =& get_instance();
		$CI->id		= $CI->session->userdata('id');
		$CI->code_type_member	= $CI->session->userdata('code_type_member');
		$CI->user	= $CI->session->userdata('user');
		$CI->name	= $CI->session->userdata('name');
		$CI->email	= $CI->session->userdata('email');
		$CI->sex	= $CI->session->userdata('sex');
		$CI->location_id	= $CI->session->userdata('location_id');
		$CI->code_city	= $CI->session->userdata('code_city');
		$CI->code_branch	= $CI->session->userdata('code_branch');
		$CI->code_tda_pengurus	= $CI->session->userdata('code_tda_pengurus');
		$CI->code_act	= $CI->session->userdata('code_act');
		$CI->profile_img	= $CI->session->userdata('profile_img');
		
		
		if ($CI->id=="") {
			redirect(site_url("login/logout")); 
		}
	}	
}
