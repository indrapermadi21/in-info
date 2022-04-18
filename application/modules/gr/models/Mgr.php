<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mgr extends CI_Model
{

    var $table = 'trans_gr';
    var $column_order = array('gr_number', 'posting_date', 'vehicle_number', 'supplier_name', null);
    var $column_search = array('gr_number', 'posting_date', 'vehicle_number', 'supplier_name');
    var $order = array('gr_number' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_query_gr()
    {

        $this->db->select("gr.*,sup.supplier_name");
        $this->db->from($this->table.' AS gr');
        $this->db->join('ms_supplier AS sup','sup.supplier_code=gr.supplier','left');

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

    function get_gr()
    {
        $d = $this->_get_query_gr();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_query_gr();
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
            'gr_number' => $this->input->post('gr_number'),
            'posting_date' => $this->input->post('posting_date'),
            'vehicle_number' => $this->input->post('vehicle_number'),
            'supplier' => $this->input->post('supplier'),
            'due_date' => $this->input->post('due_date'),
            'date_added' => date('Y-m-d h:i:s')
        );

        $total_data_item = count($this->input->post('material_code_item'));
        for ($i = 0; $i < $total_data_item; $i++) {

            $qty_item = $this->input->post('qty_item')[$i];
            $price_item = $this->input->post('price_item')[$i];
            $total = $qty_item * $price_item;

            $data_item[] = array(
                'gr_number' => $data['gr_number'],
                'material_code' => $this->input->post('material_code_item')[$i],
                'qty' => $this->input->post('qty_item')[$i],
                'uom_code' => $this->input->post('uom_code_item')[$i],
                'price' => $this->input->post('price_item')[$i],
                'total' => $total,
                'date_added' => date('Y-m-d h:i:s')
            );
        }

        for ($i = 0; $i < $total_data_item; $i++) {

            $qty_item = $this->input->post('qty_item')[$i];
            $price_item = $this->input->post('price_item')[$i];
            $total = $qty_item * $price_item;

            $data_item_mutation[] = array(
                'mutation_number' => $data['gr_number'],
                'posting_date' => $data['posting_date'],
                'material_code' => $this->input->post('material_code_item')[$i],
                'move_type' => 'GR',
                'qty' => $this->input->post('qty_item')[$i],
                'uom_code' => $this->input->post('uom_code_item')[$i],
                'price' => $this->input->post('price_item')[$i],
                'total' => $total,
                'date_added' => date('Y-m-d h:i:s')
            );
        }

        $this->db->trans_start();
        $this->db->insert($this->table, $data);
        $this->db->insert_batch('trans_gr_item', $data_item);
        $this->db->insert_batch('trans_mutation_item', $data_item_mutation);
        $this->db->trans_complete();
    }

    function is_edited()
    {

        $gr_number = $this->input->post('gr_number');
        $data = array(
            'posting_date' => $this->input->post('posting_date'),
            'vehicle_number' => $this->input->post('vehicle_number'),
            'supplier' => $this->input->post('supplier'),
            'due_date' => $this->input->post('due_date')
        );

        $total_data_item = count($this->input->post('material_code_item'));
        for ($i = 0; $i < $total_data_item; $i++) {

            $qty_item = $this->input->post('qty_item')[$i];
            $price_item = $this->input->post('price_item')[$i];
            $total = $qty_item * $price_item;

            $data_item[] = array(
                'gr_number' => $gr_number,
                'material_code' => $this->input->post('material_code_item')[$i],
                'qty' => $this->input->post('qty_item')[$i],
                'uom_code' => $this->input->post('uom_code_item')[$i],
                'price' => $this->input->post('price_item')[$i],
                'total' => $total,
                'date_added' => date('Y-m-d h:i:s')
            );
        }

        for ($i = 0; $i < $total_data_item; $i++) {

            $qty_item = $this->input->post('qty_item')[$i];
            $price_item = $this->input->post('price_item')[$i];
            $total = $qty_item * $price_item;

            $data_item_mutation[] = array(
                'mutation_number' => $gr_number,
                'posting_date' => $data['posting_date'],
                'material_code' => $this->input->post('material_code_item')[$i],
                'move_type' => 'GR',
                'qty' => $this->input->post('qty_item')[$i],
                'uom_code' => $this->input->post('uom_code_item')[$i],
                'price' => $this->input->post('price_item')[$i],
                'total' => $total,
                'date_added' => date('Y-m-d h:i:s')
            );
        }

        $this->db->trans_start();
        $this->db->where('gr_number', $gr_number);
        $this->db->update($this->table, $data);

        $this->db->where('gr_number', $gr_number);
        $this->db->delete('trans_gr_item');

        $this->db->where('mutation_number', $gr_number);
        $this->db->delete('trans_mutation_item');

        $this->db->insert_batch('trans_gr_item', $data_item);
        $this->db->insert_batch('trans_mutation_item', $data_item_mutation);

        $this->db->trans_complete();
    }

    function getGrData($gr_number)
    {
        $this->db->select('gr.*,sup.supplier_name,sup.address');
        $this->db->from($this->table.' AS gr');
        $this->db->join('ms_supplier AS sup','gr.supplier = sup.supplier_code','LEFT');
        $this->db->where('gr.gr_number', $gr_number);
        return $this->db->get()->row_array();
    }

    function getGrDataItem($gr_number)
    {
        return $this->db->query("SELECT 
            gri.gr_number AS gr_number,
            gri.material_code AS material_code,
            mat.material_description AS material_description,
            mat.uom_code AS uom_code,
            gri.qty,
            gri.price
            FROM trans_gr_item AS gri JOIN ms_material AS mat ON gri.material_code=mat.material_code 
            WHERE gri.gr_number='" . $gr_number . "'")->result_array();
    }

    function is_deleted($gr_number)
    {
        $this->db->trans_start();

        $this->db->where('mutation_number', $gr_number);
        $this->db->delete('trans_mutation_item');

        $this->db->where('gr_number', $gr_number);
        $this->db->delete('trans_gr_item');

        $this->db->where('gr_number', $gr_number);
        $this->db->delete($this->table);
        $this->db->trans_complete();
        return true;
    }

    function getMaterialCode()
    {
        return $this->db->get('ms_material')->result_array();
    }

    function getMaterialRow()
    {
        $material_code = $this->input->post('material_code');
        $this->db->where('material_code', $material_code);
        return $this->db->get('ms_material')->row();
    }

    function getSupplierList()
    {
        return $this->db->get('ms_supplier')->result_array();
    }

    function generateGrNumber(){
        $this->db->select('MAX(RIGHT(gr_number,6)) AS total');
        $counter = $this->db->get($this->table)->row_array();
        return 'GR'.str_pad((int) $counter['total'] + 1,'6',0,STR_PAD_LEFT);
    }

}
