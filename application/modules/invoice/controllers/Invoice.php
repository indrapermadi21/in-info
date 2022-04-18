<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Minvoice', 'minv');
    }

    public function index()
    {
        $this->template->load(
            'maintemplate',
            'invoice/views/v_invoice',
            [
                'job_id'     => $this->ion_auth->get_id_job(),
                'themes_url' => $this->config->item('theme_url')
            ]
        );
    }

    public function invoice_list()
    {
        $list       = $this->minv->get_invoice();
        $data       = array();

        $no         = $_POST['start'];
        foreach ($list as $inv) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $inv->invoice_number;
            $row[] = $inv->posting_date;
            $row[] = $inv->reference_number;
            $row[] = $inv->due_date;
            $row[] = $inv->payment_date;
            $row[] = $inv->customer_name;
            $row[] = number_format($inv->total, 0);
            $row[] = '<a class="btn btn-sm btn-primary" href="' . base_url('invoice/edit_invoice/' . $inv->invoice_number) . '" title="Edit"><i class="fa fa-edit"></i>Ubah</a>
            <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_invoice(' . "'" . $inv->invoice_number . "'" . ')"><i class="fa fa-trash"></i>Hapus</a>
            <a class="btn btn-sm btn-info" href="' . base_url('invoice/printInvoice/' . $inv->invoice_number) . '" target="_blank" title="Print" ><i class="fa fa-print"></i> Print</a>
            <a class="btn btn-sm btn-primary" href="' . base_url('invoice/paymentForm/' . $inv->invoice_number) . '" title="Edit"><i class="fa fa-credit-card"></i> Bayar</a>
            ';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->minv->count_all(),
            "recordsFiltered" => $this->minv->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function add_invoice()
    {
        $data['id']     = '';
        $data['type']   = 'Added';
        $data['invoice_number'] = $this->minv->generateInvoiceNumber();
        $data['result'] = array();
        $data['result_item'] = array();
        $data['material_list'] = $this->minv->getMaterialCode();
        $this->template->load('maintemplate', 'invoice/views/v_invoice_form', $data);
    }

    function edit_invoice($inv_number)
    {
        $data['type']   = 'Edited';
        $data['result'] = $this->minv->getInvoiceData($inv_number);
        $data['result_item'] = $this->minv->getInvoiceDataItem($inv_number);
        $data['material_list'] = $this->minv->getMaterialCode();
        $this->template->load('maintemplate', 'invoice/views/v_invoice_form', $data);
    }

    function saved()
    {
        $type = $this->input->post('type');
        if ($type == 'Added') {
            $this->minv->is_saved();
            $this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil tambah data penjualan'));
        } else {
            $this->minv->is_edited();
            $this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil ubah data penjualan'));
        }

        redirect('invoice');
    }

    function delete_invoice()
    {
        $inv_number = $this->input->post('invoice_number');
        $this->minv->is_deleted($inv_number);
        echo json_encode(array('status' => true));
    }

    function getMaterialRow()
    {
        $data = $this->minv->getMaterialRow();
        echo json_encode(array('data' => $data));
    }

    function printInvoice($inv_number)
    {
        $data['results'] = $this->minv->getInvoiceData($inv_number);
        $data['results_item'] = $this->minv->getInvoiceDataItem($inv_number);
        $this->load->view('print_invoice', $data);
    }

    function getSalesData()
    {
        $data = $this->minv->getSalesData();
        echo json_encode(array('data' => $data));
    }

    function paymentForm($inv_number)
    {
        $data['payment_number'] = $this->minv->getPaymentNumber();
        $data['result'] = $this->minv->getInvoicePayment($inv_number);
        $data['result_payment'] = $this->minv->getPaymentData($inv_number);
        $this->template->load('maintemplate', 'invoice/views/v_inv_payment_form', $data);
    }

    function payment()
    {
        $invoice_number = $this->input->post('invoice_number');
        $this->minv->is_payment();
        $this->session->set_flashdata(array('status' => 'success', 'message' => 'Berhasil tambah data pembayaran'));
        redirect('invoice/paymentForm/' . $invoice_number);
    }
}
