<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Sales extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Msales', 'msal');
    }

    public function index()
    {
        $this->template->load(
            'maintemplate',
            'sales/views/v_sales',
            [
                'job_id'     => $this->ion_auth->get_id_job(),
                'themes_url' => $this->config->item('theme_url')
            ]
        );
    }

    public function sales_list()
    {
        $list       = $this->msal->get_sales();
        $data       = array();

        $no         = $_POST['start'];
        foreach ($list as $sales) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $sales->sales_number;
            $row[] = $sales->posting_date;
            $row[] = $sales->vehicle_number;
            $row[] = $sales->customer_name;
            $row[] = '<a class="btn btn-sm btn-primary" href="' . base_url('sales/edit_sales/' . $sales->sales_number) . '" title="Edit"><i class="fa fa-edit"></i>Ubah</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_sales(' . "'" . $sales->sales_number . "'" . ')"><i class="fa fa-trash"></i>Hapus</a>
            <a class="btn btn-sm btn-info" href="'.base_url('sales/printSJ/'.$sales->sales_number).'" target="_blank" title="Print" ><i class="fa fa-print"></i> Print</a>
            ';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->msal->count_all(),
            "recordsFiltered" => $this->msal->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function add_sales()
    {
        $data['id']     = '';
        $data['type']   = 'Added';
        $data['sales_number'] = $this->msal->generateSalesNumber();
        $data['result'] = array();
        $data['result_item'] = array();
        $data['material_list'] = $this->msal->getMaterialCode();
        $data['customer_list'] = $this->msal->getCustomerList();
        $this->template->load('maintemplate', 'sales/views/v_sales_form', $data);
    }

    function edit_sales($sales_number)
    {
        $data['type']   = 'Edited';
        $data['result'] = $this->msal->getSalesData($sales_number);
        $data['result_item'] = $this->msal->getSalesDataItem($sales_number);
        $data['material_list'] = $this->msal->getMaterialCode();
        $data['customer_list'] = $this->msal->getCustomerList();
        $this->template->load('maintemplate', 'sales/views/v_sales_form', $data);
    }

    function saved()
    {
        $type = $this->input->post('type');
        if ($type == 'Added') {
            $this->msal->is_saved();
            $this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil tambah data penjualan'));
        } else {
            $this->msal->is_edited();
            $this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil ubah data penjualan'));
        }

        redirect('sales');
    }

    function delete_sales()
    {
        $sales_number = $this->input->post('sales_number');
        $this->msal->is_deleted($sales_number);
        echo json_encode(array('status' => true));
    }

    function getMaterialRow()
    {
        $data = $this->msal->getMaterialRow();
        echo json_encode(array('data' => $data));
    }
    
    function printSJ($sales_number){
        $data['result'] = $this->msal->getSalesDataPrint($sales_number);
        $data['result_item'] = $this->msal->getSalesDataItem($sales_number);
        $this->load->view('print_sales_order',$data);
    }
}
