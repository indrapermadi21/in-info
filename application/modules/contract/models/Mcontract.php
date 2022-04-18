<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Mcontract extends CI_Model {
 
    var $table = 'mrp_contract';
    var $column_order = array('material_code','material_description','status_val','qty','vendor_account','created_on','release_on','action_on','last_change','remarks','trans_no','mrp_id',null); 
    var $column_search = array('material_code','material_description','status_val','qty','vendor_account','created_on','release_on','action_on','last_change','remarks','trans_no','mrp_id');
    var $order = array('material_code' => 'asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    private function _get_query_contract()
    {
        
        $this->db->select("*");
        $this->db->from($this->table);
		
        // $this->db->where('value','PLANORD');
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_contract()
    {
        $d = $this->_get_query_contract();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        
        // echo $this->db->last_query();
        
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_query_contract();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }

    function updateContract(){
        $id = $this->input->post('id');
        // $material_code = $this->input->post('material_code');
        // $material_description = $this->input->post('material_description');
        // $status_val = $this->input->post('status_val');
        // $qty = $this->input->post('qty');
        $vendor_account = $this->input->post('vendor_account');
        $remarks = $this->input->post('remarks');

        $data = array(
            // 'material_code' => $material_code,
            // 'material_description' => $material_description,
            // 'status_val' => $status_val,
            // 'qty' => $qty,
            'vendor_account' => $vendor_account,
            'remarks' => $remarks,
            'last_change' => date('Y-m-d h:i:s')
        );

        $this->db->trans_start();

        $this->db->where('id',$id);
        $this->db->update($this->table,$data);

        $this->db->trans_complete();
    }

    function is_saved(){

        $this->db->trans_start();

        $this->db->trans_complete();
        
    }

    // delete data 
    function is_deleted($id){
        $this->db->trans_start();
        
            $this->db->where('id',$id);
            $dtc = $this->db->get('mrp_contract')->row();

            // delete mrp data
            $this->db->where('mrp_id',$dtc->mrp_id);
            $this->db->delete('mrp_data');
            
            // delete data contract
            $this->db->where('id',$id);
            $this->db->delete('mrp_contract');

        $this->db->trans_complete();
        return true;
    }

    function get_detail_mrp($id)
    {
        return $this->db->get_where('mrp_data',array('head_id' => $id))->result();
    }

    function approved($id){
        $this->db->trans_start();
            $this->db->where('id',$id);
            $dtc = $this->db->get('mrp_contract')->row();

            $this->db->where('mrp_id',$dtc->mrp_id);
            $mrp = $this->db->get('mrp_data')->row();

            $data_mrp = array(
                'head_id' => $mrp->head_id,
                'material_code' => $mrp->material_code,
                'material_description' => $mrp->material_description,
                'value' => 'OSC',
                'year' => $mrp->year,
                'month' => $mrp->month,
                'week' => $mrp->week,
                'qty' => $dtc->qty,
                'prch_doc' => $mrp->prch_doc,
                'confirm_del_date' => $mrp->confirm_del_date,
                'vendor_account' => $dtc->vendor_account,
                'ldt' => $mrp->ldt,
                'std_doi' => $mrp->std_doi,
                'remarks' => $dtc->remarks,
                'created_date' => $mrp->created_date
            );

            $this->db->insert('mrp_data',$data_mrp);

            $contract = array(
                'status_val' => 'OSC',
                'release_on' => date('Y-m-d h:i:s')
            );
            $this->db->where('id',$id);
            $this->db->update('mrp_contract',$contract);

        $this->db->trans_complete();
    }

    function executed($id){
        $contract = array(
            'status_val' => 'POUN',
            'action_on' => date('Y-m-d h:i:s'),
            'trans_no' => $this->generateTrans()
        );

        $this->db->trans_start();

        $this->db->where('id',$id);
        $this->db->update($this->table,$contract);



        $this->db->trans_complete();
    }

    function generateTrans(){

        $this->db->select('MAX(RIGHT(trans_no,4)) AS counter');
        $this->db->where('status_val','POUN');
        $result = $this->db->get($this->table)->row();

        $number = (int) $result->counter + 1;
        
        return '11'.sprintf("%'.04d\n", $number);
    }

   

}