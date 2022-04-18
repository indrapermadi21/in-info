<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mcustomer', 'customer');
    }

    public function index()
    {
        $this->template->load(
            'maintemplate',
            'customer/views/v_customer',
            [
                'job_id'     => $this->ion_auth->get_id_job(),
                'themes_url' => $this->config->item('theme_url')
            ]
        );
    }

    public function customer_list()
    {
        $list       = $this->customer->get_customer();
        $data       = array();

        $no         = $_POST['start'];
        foreach ($list as $customer) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $customer->customer_code;
            $row[] = $customer->customer_name;
            $row[] = $customer->address;
            $row[] = '<a class="btn btn-sm btn-primary" href="' . base_url('customer/edit_customer/' . $customer->customer_code) . '" title="Edit"> <i class="far fa-edit"></i> Ubah</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_customer(' . "'" . $customer->customer_code . "'" . ')"><i class="fa fa-trash"></i> Hapus</a>
            ';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customer->count_all(),
            "recordsFiltered" => $this->customer->count_filtered(),
            "data" => $data,
        );
        //output to json forcustomer
        echo json_encode($output);
    }

    function add_customer()
    {
        $data['id']     = '';
        $data['type']   = 'Added';
        $data['customer_code'] = $this->customer->generateCustomerCode();
        $data['result'] = array();

        $this->template->load('maintemplate', 'customer/views/v_customer_form', $data);
    }

    function edit_customer($customer_code)
    {
        $data['type']   = 'Edited';
        $data['result'] = $this->customer->getCustomerData($customer_code);

        $this->template->load('maintemplate', 'customer/views/v_customer_form', $data);
    }

    function saved()
    {
        $type = $this->input->post('type');
        if ($type == 'Added') {
            $this->customer->is_saved();
            $this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil tambah data customer'));
        } else {
            $this->customer->is_edited();
            $this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil ubah data customer'));
        }

        redirect('customer');
    }

    function delete_customer($customer_code = '')
    {
        $customer_code = $this->input->post('customer_code');
        $this->customer->is_deleted($customer_code);
        echo json_encode(array('status' => true));
    }

    // function checkCodeExist()
    // {
    //     $customer_code = $this->input->post('customer_code');

    //     // $this->db->select('customer_code');
    //     // $this->db->where('customer_code', $customer_code);
    //     // $data_exist = $this->db->get('ms_customer')->num_rows();
    //     $data_exist = $this->customer->checkCodeExist($customer_code);
    //     if ($data_exist == true) {
    //         echo json_encode(false);
    //     } else {
    //         echo json_encode(true);
    //     }
    // }
    
}
