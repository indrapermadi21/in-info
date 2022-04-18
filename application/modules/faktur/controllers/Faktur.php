<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faktur extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mfaktur', 'mfak');
    }

    public function index()
    {
        $this->template->load(
            'maintemplate',
            'faktur/views/v_faktur',
            [
                'job_id'     => $this->ion_auth->get_id_job(),
                'themes_url' => $this->config->item('theme_url')
            ]
        );
    }

    public function faktur_list()
    {
        $list       = $this->mfak->get_faktur();
        $data       = array();

        $no         = $_POST['start'];
        foreach ($list as $inv) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $inv->faktur_number;
            $row[] = $inv->posting_date;
            $row[] = $inv->reference_number;
            $row[] = $inv->due_date;
            $row[] = $inv->payment_date;
            $row[] = $inv->supplier_name;
            $row[] = number_format($inv->total,0);
            $row[] = '<a class="btn btn-sm btn-primary" href="' . base_url('faktur/edit_faktur/' . $inv->faktur_number) . '" title="Edit"><i class="fa fa-edit"></i>Ubah</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_faktur(' . "'" . $inv->faktur_number . "'" . ')"><i class="fa fa-trash"></i>Hapus</a>
            <a class="btn btn-sm btn-info" href="'.base_url('faktur/printfaktur/'.$inv->faktur_number).'" target="_blank" title="Print" ><i class="fa fa-print"></i> Print</a>
            <a class="btn btn-sm btn-primary" href="' . base_url('faktur/paymentForm/' . $inv->faktur_number) . '" title="Edit"><i class="fa fa-credit-card"></i> Bayar</a>
            ';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mfak->count_all(),
            "recordsFiltered" => $this->mfak->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function add_faktur()
    {
        $data['id']     = '';
        $data['type']   = 'Added';
        $data['faktur_number'] = $this->mfak->generateFakturNumber();
        $data['result'] = array(); 
        $data['result_item'] = array();
        $data['material_list'] = $this->mfak->getMaterialCode();
        $this->template->load('maintemplate', 'faktur/views/v_faktur_form', $data);
    }

    function edit_faktur($inv_number)
    {
        $data['type']   = 'Edited';
        $data['result'] = $this->mfak->getfakturData($inv_number);
        $data['result_item'] = $this->mfak->getfakturDataItem($inv_number);
        $data['material_list'] = $this->mfak->getMaterialCode();
        $this->template->load('maintemplate', 'faktur/views/v_faktur_form', $data);
    }

    function saved()
    {
        $type = $this->input->post('type');
        if ($type == 'Added') {
            $this->mfak->is_saved();
            $this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil tambah data penjualan'));
        } else {
            $this->mfak->is_edited();
            $this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil ubah data penjualan'));
        }

        redirect('faktur');
    }

    function delete_faktur()
    {
        $inv_number = $this->input->post('faktur_number');
        $this->mfak->is_deleted($inv_number);
        echo json_encode(array('status' => true));
    }

    function getMaterialRow()
    {
        $data = $this->mfak->getMaterialRow();
        echo json_encode(array('data' => $data));
    }
    
    function printfaktur($inv_number){
        $data['result'] = $this->mfak->getfakturDataPrint($inv_number);
        $data['result_item'] = $this->mfak->getfakturDataItem($inv_number);
        $this->load->view('print_faktur',$data);
    }

    function getGrData(){
        $data = $this->mfak->getGrData();
        echo json_encode(array('data' => $data));
    }

    function paymentForm($faktur_number)
    {
        $data['payment_number'] = $this->mfak->getPaymentNumber();
        $data['result'] = $this->mfak->getFakturPayment($faktur_number);
        $data['result_payment'] = $this->mfak->getPaymentData($faktur_number);
        $this->template->load('maintemplate', 'faktur/views/v_faktur_payment_form', $data);
    }

    function payment()
    {
        $faktur_number = $this->input->post('faktur_number');
        $this->mfak->is_payment();
        $this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil tambah data pembayaran'));
        redirect('faktur/paymentForm/' . $faktur_number);
    }
}
