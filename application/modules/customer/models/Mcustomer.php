<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mcustomer extends CI_Model
{

    var $table = 'ms_customer';
    var $column_order = array('customer_code', 'name', 'address', null);
    var $column_search = array('customer_code', 'name', 'address');
    var $order = array('customer_code' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_query_customer()
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

    function get_customer()
    {
        $d = $this->_get_query_customer();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_query_customer();
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

    function is_saved()
    {
        $data = array(
            'customer_code' => $this->input->post('customer_code'),
            'customer_name' => $this->input->post('customer_name'),
            'address' => $this->input->post('address')
        );

        $this->db->trans_start();
        $this->db->insert($this->table, $data);
        $this->db->trans_complete();
    }

    function is_edited()
    {
        $customer_code = $this->input->post('customer_code');
        $data = array(
            'customer_name' => $this->input->post('customer_name'),
            'address' => $this->input->post('address')
        );

        $this->db->trans_start();
        $this->db->where('customer_code', $customer_code);
        $this->db->update($this->table, $data);
        $this->db->trans_complete();
    }

    function getCustomerData($customer_code)
    {
        $this->db->where('customer_code', $customer_code);
        return $this->db->get($this->table)->row_array();
    }

    function is_deleted($customer_code)
    {

        $this->db->trans_start();
        $this->db->where('customer_code', $customer_code);
        $this->db->delete($this->table);
        $this->db->trans_complete();
        return true;
    }

    function generateCustomerCode(){
        $this->db->select('MAX(RIGHT(customer_code,6)) AS total');
        $counter = $this->db->get($this->table)->row_array();
        return 'CS'.str_pad((int) $counter['total'] + 1,'6',0,STR_PAD_LEFT);
    }

}
