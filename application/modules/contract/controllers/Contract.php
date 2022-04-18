<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Contract extends CI_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('Mcontract','mcn');
    }

    public function index(){
        $this->template->load('maintemplate','contract/views/v_contract', 
            [
                'job_id'     => $this->ion_auth->get_id_job(),
                'themes_url' => $this->config->item('theme_url')
            ]
        );
    }

    public function contract_list()
    {

        $job_id     = $this->ion_auth->get_id_job();
        $list       = $this->mcn->get_contract();
        $data       = array();
        

        $no         = $_POST['start'];
        foreach ($list as $contract) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $contract->material_code;
            $row[] = $contract->material_description;
            $row[] = $this->getStatus($contract->status_val);
            $row[] = $contract->qty;
            $row[] = $contract->vendor_account;
            $row[] = substr($contract->created_on,0,10);
            $row[] = substr($contract->release_on,0,10);
            $row[] = substr($contract->action_on,0,10);
            $row[] = substr($contract->last_change,0,10);
            $row[] = $contract->remarks;
            // $row[] = $this->button_html($job_id,$contract->status,$contract->mrp_id);
            $row[] = $this->button_html($contract->id,$job_id,$contract->status_val);
            $row[] = $contract->trans_no;
            
            $data[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mcn->count_all(),
            "recordsFiltered" => $this->mcn->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function button_html($id,$job_id,$status){
        if($job_id=='1'){
            if($status=='PLANORD'){
                $button = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Approve" onclick="approve_contract('."'".$id."'".')"><i class="fa fa-pencil"></i> Approve</a>';
            } elseif($status=='POUN'){
                $button = '<label class="btn btn-sm btn-info">Done</label>';
            } else {
                $button = '-';
            }
        } else {
            if($status=='PLANORD'){
                $button = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_contract('."'".$id."'".')"><i class="fa fa-pencil"></i> Edit</a>
                <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Delete" onclick="delete_contract('."'".$id."'".')"><i class="fa fa-trash"></i> Delete</a>
                ';
                
            } elseif($status=='OSC'){
                $button = '<a class="btn btn-sm btn-success" href="javascript:void(0)" title="Execute" onclick="execute_contract('."'".$id."'".')"><i class="fa fa-pencil"></i> Execute</a>
                ';
            } elseif($status=='POUN'){
                $button = '<label class="btn btn-sm btn-info">Done</label>';
            } else {
                $button = '-';
            }
        }

        return $button;
    }

    function getContractEdit($id){
        $data = $this->mcn->get_by_id($id);
        echo json_encode($data);
    }

    function contract_edit(){
        // $this->mdoc->update(array('id' => $id), $data);
        $this->mcn->updateContract();
        redirect('contract');
    }

    function getStatus($value){
        return $this->db->get_where('ms_stat',array('stat_code' => $value))->row()->description;
    }

    function get_detail($id)
    {
        $data['result'] = $this->mgr->get_detail_mrp($id);
        $this->template->load('blanktemplate','mrp/views/mrp_detail', $data);
    }

    function mrp_add()
    {   
        $themes_url 		= 'themes/hr/';
		$data['themes_url'] = base_url($themes_url);
        
        $data['id']     = '';
        $data['type']   = 'Added';

        $this->template->load('maintemplate','mrp/views/v_mrp_form', $data);
    }

    public function export(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        $writer = new Xlsx($spreadsheet);
        $filename = 'name-of-the-generated-file';
        
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output'); // download file
    }

    public function import(){
        $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if(isset($_FILES['upload_file']['name']) && in_array($_FILES['upload_file']['type'], $file_mimes)) {
            $arr_file = explode('.', $_FILES['upload_file']['name']);
            $extension = end($arr_file);
            if('csv' == $extension){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($_FILES['upload_file']['tmp_name']);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            
            $this->db->trans_start();

            $data_head = array(
                'posting_date' => date('Y-m-d'),
                'description' => '',
                'date_added' => date('Y-m-d h:i:s')
            );

            $this->db->insert('mrp_head',$data_head);
            $last_id = $this->db->insert_id();

            for($i=1;$i < count($sheetData);$i++){
                $material_code = $sheetData[$i][0];
                $material_description = $sheetData[$i][1];
                $material_group = $sheetData[$i][2];
                $bun = $sheetData[$i][3];
                $plant = $sheetData[$i][4];
                $price = $sheetData[$i][5];
                $value = $sheetData[$i][6];
                $year    = $sheetData[$i][7];
                $month    = $sheetData[$i][8];
                $week    = $sheetData[$i][9];
                $qty    = $sheetData[$i][10];
                $amount    = $sheetData[$i][11];
                $prch_doc    = $sheetData[$i][12];
                $confirm_del_date    = $sheetData[$i][13];
                $vendor_account    = $sheetData[$i][14];
                $mps_fg    = $sheetData[$i][15];
                $mps_desc    = $sheetData[$i][16];

                $data = array(
                    'head_id' => $last_id,
                    'material_code' => $material_code,
                    'material_description' => $material_description,
                    'material_group' => $material_group,
                    'bun' => $bun,
                    'plant' => $plant,
                    'price' => $price,
                    'value' => $value,
                    'year' => $year,
                    'month' => $month,
                    'week' => $week,
                    'qty' => $qty,
                    'amount' => $amount,
                    'prch_doc' => $prch_doc,
                    'confirm_del_date' => $confirm_del_date,
                    'vendor_account' => $vendor_account,
                    'mps_fg' => $mps_fg,
                    'mps_desc' => $mps_desc,
                );

                $this->db->insert('mrp_data',$data);
                
            }
            
            
            $this->db->trans_complete();
            redirect('mrp');
        }
    }

    // approve by manager
    function contract_approve(){
        $id = $this->input->post('id');
        $this->mcn->approved($id);
        echo json_encode(array('status' => true));
    }

    function contract_execute(){
        $id = $this->input->post('id');
        $this->mcn->executed($id);
        echo json_encode(array('status' => true));
    }
    
    function contract_delete(){
        $id = $this->input->post('id');
        $this->mcn->is_deleted($id);
        echo json_encode(array('status' => true));
    }
}