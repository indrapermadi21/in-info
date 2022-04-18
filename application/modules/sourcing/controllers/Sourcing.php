<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sourcing extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Msourcing', 'msou');
    }

    public function index()
    {
        $this->template->load(
            'maintemplate',
            'sourcing/views/v_sourcing',
            [
                'job_id'     => $this->ion_auth->get_id_job(),
                'themes_url' => $this->config->item('theme_url')
            ]
        );
    }

    public function sourcing_list()
    {

        $job_id     = $this->ion_auth->get_id_job();
        $list       = $this->msou->get_sourcing();
        $data       = array();

        $no         = $_POST['start'];
        foreach ($list as $sourcing) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = "<img src='".base_url('upload/'.$sourcing->image)."' width='50' height='50'>";
            $row[] = $sourcing->material_code;
            $row[] = $sourcing->material_description;
            $row[] = $sourcing->material_group;
            $row[] = $sourcing->vendor_account;
            $row[] = $sourcing->ldt;
            $row[] = $sourcing->std_doi;
            $row[] = $sourcing->moq;
            // $row[] = $this->button_html($job_id,$sourcing->status,$sourcing->mrp_id);
            $row[] = '<a class="btn btn-sm btn-primary" href="'.base_url('sourcing/sourcing_edit/'.$sourcing->id).'" title="Edit"<i class="fa fa-pencil"></i> Edit</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_sourcing('."'".$sourcing->id."'".')"><i class="fa fa-trash"></i> Delete</a>
            ';
            // $row[] = '';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->msou->count_all(),
            "recordsFiltered" => $this->msou->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function sourcing_add()
    {
        $themes_url         = 'themes/hr/';
        $data['themes_url'] = base_url($themes_url);

        $data['id']     = '';
        $data['type']   = 'Added';
        $data['result'] = array();

        $this->template->load('maintemplate', 'sourcing/views/v_sourcing_form', $data);
    }

    function sourcing_edit($id)
    {
        $themes_url         = 'themes/hr/';
        $data['themes_url'] = base_url($themes_url);

        $data['id']     = $id;
        $data['type']   = 'Edited';
        $data['result'] = $this->msou->getSourcingData($id);

        $this->template->load('maintemplate', 'sourcing/views/v_sourcing_form', $data);
    }

    function saved()
    {
        $type = $this->input->post('type');
        if($type=='Edited'){
            $this->edited();
        } else {
            $this->msou->is_saved();
            $this->session->set_flashdata(array('status'=>'success','message' => 'Success added sourcing data'));
        }
        
        redirect('sourcing');
    }

    function edited()
    {
        $this->msou->is_edited();
        $this->session->set_flashdata(array('status'=>'success','message' => 'Success edited sourcing data'));
        // redirect('sourcing');
    }

    function sourcing_delete(){
        $id = $this->input->post('id');
        $this->msou->is_deleted($id);
        echo json_encode(array('status' => true));
    }
}
