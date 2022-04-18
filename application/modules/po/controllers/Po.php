<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Po extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Mpo','mpo');
    }

    public function index(){
        $this->template->load('maintemplate','po/views/v_po', 
            [
                'job_id'     => $this->ion_auth->get_id_job(),
                'themes_url' => $this->config->item('theme_url')
            ]
        );
    }

    public function po_list()
    {
        $list       = $this->mpo->get_po();
        $data       = array();

        $no         = $_POST['start'];
        foreach ($list as $po) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $po->material_code;
            $row[] = $po->material_description;
            $row[] = $po->value;
            $row[] = $po->confirm_del_date;
            $row[] = $po->qty;
            $row[] = $po->prch_doc;
            $row[] = $po->vendor_account;
            $row[] = $po->remarks;
            
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mpo->count_all(),
            "recordsFiltered" => $this->mpo->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function get_detail($id)
    {
        $data['result'] = $this->mpo->get_detail_mrp($id);
        $this->template->load('blanktemplate','mrp/views/mrp_detail', $data);
    }
}