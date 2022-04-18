<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Mrp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mmrp', 'mmrp');
    }

    public function index()
    {
        $this->template->load(
            'maintemplate',
            'mrp/views/v_mrp',
            [
                'job_id'     => $this->ion_auth->get_id_job(),
                'themes_url' => $this->config->item('theme_url')
            ]
        );
    }

    public function mrp_list()
    {
        $list       = $this->mmrp->get_mrp();
        $data       = array();

        $no         = $_POST['start'];
        foreach ($list as $mmrp) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $mmrp->posting_date;
            $row[] = $mmrp->description;
            $row[] = '<a class="btn btn-sm btn-primary" href="' . base_url('mrp/get_detail/' . $mmrp->id) . '" title="Detail" ><i class="fa fa-pencil"></i> Detail</a>
            <a class="btn btn-sm btn-danger" href="' . base_url('mrp/get_detail/' . $mmrp->id) . '" title="Detail" ><i class="fa fa-trash"></i> Delete</a>
            ';
            
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mmrp->count_all(),
            "recordsFiltered" => $this->mmrp->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function get_detail($id)
    {
        $data['result'] = $this->mmrp->get_detail_mrp($id);
        $this->template->load('blanktemplate', 'mrp/views/mrp_detail', $data);
    }

    function mrp_add()
    {
        $themes_url         = 'themes/hr/';
        $data['themes_url'] = base_url($themes_url);

        $data['id']     = '';
        $data['type']   = 'Added';

        $this->template->load('maintemplate', 'mrp/views/v_mrp_form', $data);
    }

    public function mrp_recap()
    {
        $themes_url         = 'themes/hr/';
        $data['themes_url'] = base_url($themes_url);

        $data['id']     = '';

        $this->template->load('maintemplate', 'mrp/views/v_recap', $data);
    }

    public function mrp_data_detail($created_date)
    {
        $data['year_month'] = '';
        $data['material_code'] = '';
        $data['plan_order_cal'] = '';
        $data['head_id'] = '';
        $data['results'] = $this->mmrp->checkDataMrp($created_date);
        $data['created_date'] = $created_date;
        $data['has_contract'] = $this->mmrp->getDataHasContract($data['year_month']);
        $data['modelMrp'] = $this->mmrp;

        $result['data'] = $this->template->load('blanktemplate', 'mrp/views/v_recap_detail', $data, true);

        echo json_encode($result);
    }

    public function mrp_data_detail_calculate($created_date, $plan_order = 0, $material_code, $year_month, $head_id = 0)
    {
        $data['year_month'] = $year_month;
        $data['material_code'] = $material_code;
        $data['plan_order_cal'] = $plan_order;
        $data['head_id'] = $head_id;
        $data['results'] = $this->mmrp->checkDataMrp($created_date);
        $data['has_contract'] = $this->mmrp->getDataHasContract($data['year_month']);
        $data['created_date'] = $created_date;
        $data['modelMrp'] = $this->mmrp;
        
        $result['data'] = $this->template->load('blanktemplate', 'mrp/views/v_recap_detail', $data, true);
        echo json_encode($result);
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        $writer = new Xlsx($spreadsheet);
        $filename = 'name-of-the-generated-file';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); // download file
    }

    public function purpose_data()
    {
        $material_code = $this->input->post('material_code');
        $month = $this->input->post('month');
        $head_id = $this->input->post('head_id');
        $plan_order = $this->input->post('plan_order');

        if ($this->mmrp->purpose_query($material_code, $month, $head_id, $plan_order)) {
            echo json_encode(array("status" => TRUE, 'message' => 'Data successfully propose'));
        } else {
            echo json_encode(array("status" => FALSE, 'message' => 'Data failed to propose'));
        }
    }

    public function download_excel($created_date)
    {
        $spreadsheet = new Spreadsheet();

        $result = $this->mmrp->getDataMrp($created_date);

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Material Code');
        $sheet->setCellValue('B1', 'Description');
        $sheet->setCellValue('C1', 'Value');
        $sheet->setCellValue('D1', 'Year');
        $sheet->setCellValue('E1', 'Month');
        $sheet->setCellValue('F1', 'Week');
        $sheet->setCellValue('G1', 'Qty');
        $sheet->setCellValue('H1', 'Confirm Del. Date');
        $sheet->setCellValue('I1', 'Purch. Doc');
        $sheet->setCellValue('J1', 'Vendor Account Number');
        $sheet->setCellValue('K1', 'Ldt');
        $sheet->setCellValue('L1', 'Std DOI');

        $i = 2;
        foreach ($result as $row) {
            $sheet->setCellValue('A' . $i, $row->material_code);
            $sheet->setCellValue('B' . $i, $row->material_description);
            $sheet->setCellValue('C' . $i, $row->value);
            $sheet->setCellValue('D' . $i, $row->year);
            $sheet->setCellValue('E' . $i, $row->month);
            $sheet->setCellValue('F' . $i, $row->week);
            $sheet->setCellValue('G' . $i, $row->qty);
            $sheet->setCellValue('H' . $i, $row->confirm_del_date);
            $sheet->setCellValue('I' . $i, $row->prch_doc);
            $sheet->setCellValue('J' . $i, $row->vendor_account);
            $sheet->setCellValue('K' . $i, $row->ldt);
            $sheet->setCellValue('L' . $i, $row->std_doi);
            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'MRP Data';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); // download file
    }

    public function import()
    {
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if (isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['upload_file']['name']);
            $extension = end($arr_file);
            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $posting_date = date('Y-m-d');
            $this->db->where('posting_date', $posting_date);
            $count_data = $this->db->get('mrp_head')->num_rows();

            if ($count_data > 0) {
                // echo json_encode(array('status' => false,'icon' => 'error','message' => 'Data on this date has already exist'));
                $this->session->set_flashdata(array('status' => 'error', 'message' => 'On this date has already exist'));
                redirect('mrp/mrp_add');
                exit;
            }

            $this->db->trans_start();

            $data_head = array(
                'posting_date' => $posting_date,
                'description' => '',
                'date_added' => date('Y-m-d h:i:s')
            );

            $this->db->insert('mrp_head', $data_head);
            $last_id = $this->db->insert_id();

            for ($i = 1; $i < count($sheetData); $i++) {
                $material_code = $sheetData[$i][0];
                $material_description = $sheetData[$i][1];
                $value = $sheetData[$i][2];
                $year    = $sheetData[$i][3];
                $month    = str_pad($sheetData[$i][4], 2, "0", STR_PAD_LEFT);
                $week    = $sheetData[$i][5];
                $qty    = $sheetData[$i][6];
                $confirm_del_date    = $sheetData[$i][7];
                $prch_doc    = $sheetData[$i][8];
                $vendor_account    = $sheetData[$i][9];
                $ldt    = $sheetData[$i][10];
                $std_doi    = $sheetData[$i][11];

                $data = array(
                    'head_id' => $last_id,
                    'material_code' => $material_code,
                    'material_description' => $material_description,
                    'value' => $value,
                    'year' => $year,
                    'month' => $month,
                    'week' => $week,
                    'qty' => $qty,
                    'prch_doc' => $prch_doc,
                    'confirm_del_date' => $confirm_del_date,
                    'vendor_account' => $vendor_account,
                    'ldt' => $ldt,
                    'std_doi' => $std_doi,
                    'remarks' => '',
                    'created_date' => date('Y-m-d')
                );

                $this->db->insert('mrp_data', $data);
            }

            $this->session->set_flashdata(array('status' => 'success', 'message' => 'Success uploaded'));
            $this->db->trans_complete();
            redirect('mrp/mrp_add');
        }
    }

    function mrp_data_delete()
    {

        if ($this->mmrp->deleteMrpData()) {

            $created_date = $this->input->post('created_date');
            $data['results'] = $this->mmrp->checkDataMrp($created_date);
            $result['data'] = $this->template->load('blanktemplate', 'mrp/views/v_recap_detail', $data, true);

            echo json_encode(array('status' => true, 'icon' => 'success', 'message' => 'Data deleted', 'data' => $result['data']));
        }
    }
}
