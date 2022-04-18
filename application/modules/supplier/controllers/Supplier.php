<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Msupplier', 'supplier');
    }

    public function index()
    {
        $this->template->load(
            'maintemplate',
            'supplier/views/v_supplier',
            [
                'job_id'     => $this->ion_auth->get_id_job(),
                'themes_url' => $this->config->item('theme_url')
            ]
        );
    }

    public function supplier_list()
    {
        $list       = $this->supplier->get_supplier();
        $data       = array();

        $no         = $_POST['start'];
        foreach ($list as $supplier) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $supplier->supplier_code;
            $row[] = $supplier->supplier_name;
            $row[] = $supplier->address;
            $row[] = '<a class="btn btn-sm btn-primary" href="' . base_url('supplier/edit_supplier/' . $supplier->supplier_code) . '" title="Edit"> <i class="far fa-edit"></i> Ubah</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_supplier(' . "'" . $supplier->supplier_code . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>
            ';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->supplier->count_all(),
            "recordsFiltered" => $this->supplier->count_filtered(),
            "data" => $data,
        );
        //output to json forsupplier
        echo json_encode($output);
    }

    function add_supplier()
    {
        $data['id']     = '';
        $data['type']   = 'Added';
        $data['supplier_code'] = $this->supplier->generateSupplierCode();
        $data['result'] = array();

        $this->template->load('maintemplate', 'supplier/views/v_supplier_form', $data);
    }

    function edit_supplier($supplier_code)
    {
        $data['type']   = 'Edited';
        $data['result'] = $this->supplier->getSupplierData($supplier_code);

        $this->template->load('maintemplate', 'supplier/views/v_supplier_form', $data);
    }

    function saved()
    {
        $type = $this->input->post('type');
        if ($type == 'Added') {
            $this->supplier->is_saved();
            $this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil tambah data supplier'));
        } else {
            $this->supplier->is_edited();
            $this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil ubah data supplier'));
        }

        redirect('supplier');
    }

    function delete_supplier($supplier_code = '')
    {
        $supplier_code = $this->input->post('supplier_code');
        $this->supplier->is_deleted($supplier_code);
        echo json_encode(array('status' => true));
    }

    // function checkCodeExist()
    // {
    //     $supplier_code = $this->input->post('supplier_code');

    //     // $this->db->select('supplier_code');
    //     // $this->db->where('supplier_code', $supplier_code);
    //     // $data_exist = $this->db->get('ms_supplier')->num_rows();
    //     $data_exist = $this->supplier->checkCodeExist($supplier_code);
    //     if ($data_exist == true) {
    //         echo json_encode(false);
    //     } else {
    //         echo json_encode(true);
    //     }
    // }
    
}
