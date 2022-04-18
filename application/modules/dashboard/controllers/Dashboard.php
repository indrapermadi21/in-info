<?php

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('dashboard/Mdashboard','mdash');

    }

    function index() {
        
        $this->template->load('maintemplate','dashboard/views/v_dashboard_new', 
            [
                'job_id'     => $this->ion_auth->get_id_job(),
                'themes_url' => $this->config->item('theme_url'),
                'result'     => $this->mdash->getContract()
            ]
        );
   }

    public function plan_order(){
        $themes_url 		= 'themes/hr/';
		$data['themes_url'] = base_url($themes_url);
        
        $data['results'] = $this->mdash->getPlanData();
        
        $this->template->load('maintemplate','dashboard/views/v_dash_plan_order', $data);
    }

    public function os_contract(){
        $themes_url 		= 'themes/hr/';
		$data['themes_url'] = base_url($themes_url);
        
        $data['results'] = $this->mdash->getOsContract();
        
        $this->template->load('maintemplate','dashboard/views/v_dash_osc', $data);
    }

    public function po_unrelease(){
        $themes_url 		= 'themes/hr/';
		$data['themes_url'] = base_url($themes_url);
        
        $data['results'] = $this->mdash->getPoUn();
        
        $this->template->load('maintemplate','dashboard/views/v_dash_poun', $data);
    }

}
