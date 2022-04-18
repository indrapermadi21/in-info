<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mmrp extends CI_Model
{

    var $table = 'mrp_head';
    var $column_order = array('posting_date', 'description', null);
    var $column_search = array('posting_date', 'description');
    var $order = array('posting_date' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_query_mrp()
    {

        $this->db->select("*");
        $this->db->from($this->table);

        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_mrp()
    {
        $d = $this->_get_query_mrp();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_query_mrp();
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
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    function get_detail_mrp($id)
    {
        return $this->db->get_where('mrp_data', array('head_id' => $id))->result();
    }

    function checkDataMrp($date)
    {
        $query = "
            SELECT 
                material_code,
                head_id,
                material_description,
                ldt,
                std_doi,
                created_date,
                year,
                month,
                SUM(IF(value='STOCK',qty,0)) AS stock,
                SUM(IF(value='REQ',qty,0)) AS requirement,
                SUM(IF(value='ACT',qty,0)) AS actual,
                SUM(IF(value='OSC',qty,0)) AS os_contract,
                SUM(IF(value='POUN',qty,0)) AS po_unrelease,
                SUM(IF(value='GR',qty,0)) AS gr,
                SUM(IF(value='PO',qty,0)) AS po,
                SUM(IF(value='PLANORD',qty,0)) AS plan_order
                
            FROM mrp_data WHERE created_date='" . $date . "' GROUP BY material_code,year,month
        ";

        return $this->db->query($query)->result();
    }

    function getDataMrp($date)
    {
        $this->db->where('created_date', $date);
        return $this->db->get('mrp_data')->result();
    }

    function purpose_query($material_code, $month, $head_id, $plan_order = 0)
    {
        $this->db->select("
                head_id,
                material_code,
                material_description,
                ldt,
                std_doi,
                created_date,
                year,
                month,
                SUM(IF(value='STOCK',qty,0)) AS stock,
                SUM(IF(value='REQ',qty,0)) AS requirement,
                SUM(IF(value='ACT',qty,0)) AS actual,
                SUM(IF(value='OSC',qty,0)) AS os_contract,
                SUM(IF(value='GR',qty,0)) AS gr,
                SUM(IF(value='PO',qty,0)) AS po,
                SUM(IF(value='PLANORD',qty,0)) AS plan_order
        ")->from('mrp_data')->where("
            material_code = '" . $material_code . "'  AND year='" . substr($month, 0, 4) . "' AND month='" . substr($month, -2) . "'
        ");
        $row = $this->db->get()->row();

        $ending_stock = $row->stock + $row->requirement + $row->actual + $row->po;
        $std_doi = $row->std_doi * $row->requirement;
        $total_pogr = $row->po + $row->gr;
        $suggest_plan = $ending_stock + $std_doi;
        $this->db->trans_begin();
        $this->db->query("
            INSERT mrp_data (head_id,material_code,material_description,value,year,month,week,qty,prch_doc,confirm_del_date,vendor_account,ldt,std_doi,remarks,created_date)
            SELECT " . $head_id . ",material_code,material_description,'EDSTOCK','" . substr($month, 0, 4) . "','" . substr($month, -2) . "',week," . $ending_stock . ",prch_doc,confirm_del_date,vendor_account,ldt,std_doi,remarks,created_date
            FROM mrp_data WHERE material_code = '" . $material_code . "'  AND year='" . substr($month, 0, 4) . "' AND month='" . substr($month, -2) . "' AND head_id = " . $head_id . " LIMIT 1
        ");

        // echo $this->db->last_query().'<br>';
        $this->db->query("
            INSERT mrp_data (head_id,material_code,material_description,value,year,month,week,qty,prch_doc,confirm_del_date,vendor_account,ldt,std_doi,remarks,created_date)
            SELECT " . $head_id . ",material_code,material_description,'STDDOI','" . substr($month, 0, 4) . "','" . substr($month, -2) . "',week," . $std_doi . ",prch_doc,confirm_del_date,vendor_account,ldt,std_doi,remarks,created_date
            FROM mrp_data WHERE material_code = '" . $material_code . "'  AND year='" . substr($month, 0, 4) . "' AND month='" . substr($month, -2) . "' AND head_id = " . $head_id . " LIMIT 1
        ");
        // echo $this->db->last_query().'<br>';
        $this->db->query("
            INSERT mrp_data (head_id,material_code,material_description,value,year,month,week,qty,prch_doc,confirm_del_date,vendor_account,ldt,std_doi,remarks,created_date)
            SELECT " . $head_id . ",material_code,material_description,'PLANORD','" . substr($month, 0, 4) . "','" . substr($month, -2) . "',week," . $plan_order . ",prch_doc,confirm_del_date,vendor_account,ldt,std_doi,remarks,created_date
            FROM mrp_data WHERE material_code = '" . $material_code . "'  AND year='" . substr($month, 0, 4) . "' AND month='" . substr($month, -2) . "' AND head_id = " . $head_id . " LIMIT 1
        ");
        // echo $this->db->last_query().'<br>';
        $last_id = $this->db->insert_id();

        // $this->db->select("MAX(mrp_id) AS last_id");
        // $last_id = $this->db->get('mrp_data')->row()->last_id;
        // echo $last_id.'<br>';
        $this->db->query("
            INSERT mrp_contract (material_code,material_description,status_val,qty,vendor_account,created_on,release_on,action_on,last_change,remarks,mrp_id,year,month)
            SELECT material_code,material_description,value,qty,'','" . date('Y-m-d h:i:s') . "','','','" . date('Y-m-d h:i:s') . "',remarks," . $last_id . ",'" . substr($month, 0, 4) . "','" . substr($month, -2) . "'
            FROM mrp_data WHERE mrp_id=" . $last_id . "
        ");

        // echo $this->db->last_query();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function deleteMrpData()
    {
        $created_date = $this->input->post('created_date');

        // Check data on date
        $this->db->where('created_date', $created_date);
        $check_data = $this->db->get('mrp_data')->num_rows();
        if ($check_data == 0) {
            echo json_encode(array('status' => false, 'icon' => 'error', 'message' => 'Data not found'));
            exit;
        }

        $this->db->trans_begin();

        //get data to delete item
        $this->db->where('posting_date', $created_date);
        $get_id = $this->db->get($this->table)->row('id');

        $this->db->where('head_id', $get_id);
        $this->db->delete('mrp_data');

        $this->db->where('id', $get_id);
        $this->db->delete($this->table);


        $this->db->trans_complete();
        return true;
    }

    function getDataHasContract($created_date)
    {
        // $year = substr($year_month,0,4);
        // $month = substr($year_month,-2);

        return $this->db->query("
            SELECT
                material_code,
                year,month 
            FROM 
                mrp_contract
        ")->result_array();
    }

    function checkContract($head_id, $year_month, $material_code)
    {
        $this->db->where('material_code', $material_code);
        $this->db->where('year', substr($year_month, 0, 4));
        $this->db->where('month', substr($year_month, -2));
        $mrp = $this->db->get('mrp_contract')->row();

        if (!$mrp) {
            return false;
        } else {
            $this->db->where('mrp_id', $mrp->mrp_id);
            $head_id_mrp = $this->db->get('mrp_data')->row_array();

            if ($head_id == $head_id_mrp['head_id']) {
                return true;
            } else {
                return false;
            }
        }
    }

    function checkContractStatus($head_id, $year_month, $material_code)
    {
        $this->db->where('material_code', $material_code);
        $this->db->where('year', substr($year_month, 0, 4));
        $this->db->where('month', substr($year_month, -2));
        $mrp = $this->db->get('mrp_contract')->row_array();

        $status = !$mrp ? '' : $mrp['status_val']; 

        return $status;
    }
}
