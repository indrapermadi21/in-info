<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mmat extends CI_Model
{

    var $table = 'ms_material';
    var $column_order = array('material_code', 'material_description', 'uom_code','supplier_name', null);
    var $column_search = array('material_code', 'material_description', 'uom_code','supplier_name');
    var $order = array('material_code' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_query_material()
    {

        $this->db->select("*");
        $this->db->from($this->table.' AS mat');
        $this->db->join('ms_supplier AS sup','mat.supplier_code=sup.supplier_code','LEFT');

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

    function get_material()
    {
        $d = $this->_get_query_material();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_query_material();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function is_saved()
    {
        $data = array(
            'material_code' => $this->input->post('material_code'),
            'material_description' => $this->input->post('material_description'),
            'uom_code' => $this->input->post('uom_code'),
            'supplier_code' => $this->input->post('supplier_code')
        );

        $this->db->trans_start();
        $this->db->insert($this->table, $data);
        $this->db->trans_complete();
    }

    function is_edited()
    {

        $material_code = $this->input->post('material_code');
        $data = array(
            'material_description' => $this->input->post('material_description'),
            'uom_code' => $this->input->post('uom_code'),
            'supplier_code' => $this->input->post('supplier_code')
        );

        $this->db->trans_start();
        $this->db->where('material_code', $material_code);
        $this->db->update($this->table, $data);
        $this->db->trans_complete();
    }

    function getMaterialData($material_code)
    {
        $this->db->where('material_code', $material_code);
        return $this->db->get($this->table)->row_array();
    }

    function is_deleted($material_code)
    {
        $this->db->trans_start();
        $this->db->where('material_code', $material_code);
        $this->db->delete($this->table);
        $this->db->trans_complete();
        return true;
    }

    function getSupplierCode()
    {
        return $this->db->get('ms_supplier')->result_array();
    }

    function generateMaterialCode(){
        $this->db->select('MAX(RIGHT(material_code,6)) AS count_material');
        $counter = $this->db->get($this->table)->row_array();
        return 'M'.str_pad((int) $counter['count_material'] + 1,'6',0,STR_PAD_LEFT);
    }
}
