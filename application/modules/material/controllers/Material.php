<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Mmat','mat');
    }

    public function index(){
        $this->template->load('maintemplate','material/views/v_material', 
            [
                'job_id'     => $this->ion_auth->get_id_job(),
                'themes_url' => $this->config->item('theme_url')
            ]
        );
    }

    public function material_list()
    {
        $list       = $this->mat->get_material();
        $data       = array();

        $no         = $_POST['start'];
        foreach ($list as $mat) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $mat->material_code;
            $row[] = $mat->material_description;
            $row[] = $mat->uom_code;
            $row[] = $mat->supplier_name;
            $row[] = '<a class="btn btn-sm btn-primary" href="'.base_url('material/edit_material/'.$mat->material_code).'" title="Edit"><i class="fa fa-edit"></i> Ubah</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_material('."'".$mat->material_code."'".')"><i class="fa fa-trash"></i> Hapus</a>
            ';
            
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mat->count_all(),
            "recordsFiltered" => $this->mat->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function get_detail($material_code)
    {
        $data['result'] = $this->mat->get_material($material_code);
        $this->template->load('blanktemplate','material/views/mrp_detail', $data);
    }

    function add_material(){
        $data['id']     = '';
        $data['type']   = 'Added';
        $data['result'] = array();
        $data['material_code'] = $this->mat->generateMaterialCode();
        $data['supplier_list'] = $this->mat->getSupplierCode();

        $this->template->load('maintemplate', 'material/views/v_material_form', $data);
    }

    function edit_material($material_code){
        $data['type']   = 'Edited';
        $data['result'] = $this->mat->getMaterialData($material_code);
        $data['supplier_list'] = $this->mat->getSupplierCode();
        $this->template->load('maintemplate', 'material/views/v_material_form', $data);
    }

    function saved(){
        $type = $this->input->post('type');
        if($type=='Added'){
            $this->mat->is_saved();
            $this->session->set_flashdata(array('status'=>'success','message' => 'Success Add Material data'));
        } else {
            $this->mat->is_edited();
            $this->session->set_flashdata(array('status'=>'success','message' => 'Success Edit material data'));
        }

        redirect('material');
    }

    function delete_material($material_code=''){
        $material_code = $this->input->post('material_code');
        $this->mat->is_deleted($material_code);
        echo json_encode(array('status' => true));
    }
}