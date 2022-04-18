<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gr extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mgr', 'mgr');
    }

    public function index()
    {
        $this->template->load(
            'maintemplate',
            'gr/views/v_gr',
            [
                'job_id'     => $this->ion_auth->get_id_job(),
                'themes_url' => $this->config->item('theme_url')
            ]
        );
    }

    public function gr_list()
    {
        $list       = $this->mgr->get_gr();
        $data       = array();

        $no         = $_POST['start'];
        foreach ($list as $gr) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $gr->gr_number;
            $row[] = $gr->posting_date;
            $row[] = $gr->vehicle_number;
            $row[] = $gr->supplier_name;
            $row[] = $gr->due_date;
            $row[] = '<a class="btn btn-sm btn-primary" href="' . base_url('gr/edit_gr/' . $gr->gr_number) . '" title="Edit"><i class="fa fa-edit"></i> Ubah</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_gr(' . "'" . $gr->gr_number . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>
            <a class="btn btn-sm btn-info" href="'.base_url('gr/printSJ/'.$gr->gr_number).'" target="_blank" title="Print" ><i class="fa fa-print"></i> Print</a>
            ';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mgr->count_all(),
            "recordsFiltered" => $this->mgr->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function add_gr()
    {
        $data['id']     = '';
        $data['type']   = 'Added';
        $data['gr_number'] = $this->mgr->generateGrNumber();
        $data['result'] = array();
        $data['result_item'] = array();
        $data['material_list'] = $this->mgr->getMaterialCode();
        $data['supplier_list'] = $this->mgr->getSupplierList();

        $this->template->load('maintemplate', 'gr/views/v_gr_form', $data);
    }

    function edit_gr($gr_number)
    {
        $data['type']   = 'Edited';
        $data['result'] = $this->mgr->getGrData($gr_number);
        $data['result_item'] = $this->mgr->getGrDataItem($gr_number);
        $data['material_list'] = $this->mgr->getMaterialCode();
        $data['supplier_list'] = $this->mgr->getSupplierList();
        $this->template->load('maintemplate', 'gr/views/v_gr_form', $data);
    }

    function saved()
    {
        $type = $this->input->post('type');
        if ($type == 'Added') {
            $this->mgr->is_saved();
            $this->session->set_flashdata(array('status' => 'success', 'message' => 'Success Add Gr data'));
        } else {
            $this->mgr->is_edited();
            $this->session->set_flashdata(array('status' => 'success', 'message' => 'Success Edit Gr data'));
        }

        redirect('gr');
    }

    function delete_gr()
    {
        $gr_number = $this->input->post('gr_number');
        $this->mgr->is_deleted($gr_number);
        echo json_encode(array('status' => true));
    }

    function getMaterialRow()
    {
        $data = $this->mgr->getMaterialRow();
        echo json_encode(array('data' => $data));
    }

    function printSJ($gr_number){
        $data['result'] = $this->mgr->getGrData($gr_number);
        $data['result_item'] = $this->mgr->getGrDataItem($gr_number);
        $this->load->view('print_gr',$data);
    }
}
