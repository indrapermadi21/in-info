<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Msales extends CI_Model
{

    var $table = 'trans_sales';
    var $column_order = array('sl.sales_number', 'sl.posting_date', 'sl.vehicle_number', 'cus.customer_name', null);
    var $column_search = array('sl.sales_number', 'sl.posting_date', 'sl.vehicle_number', 'cus.customer_name');
    var $order = array('sl.sales_number' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_query_sales()
    {

        $this->db->select("*");
        $this->db->from($this->table.' AS sl');
        $this->db->join('ms_customer AS cus','sl.customer=cus.customer_code','left');

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

    function get_sales()
    {
        $d = $this->_get_query_sales();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_query_sales();
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
            'sales_number' => $this->input->post('sales_number'),
            'posting_date' => $this->input->post('posting_date'),
            'vehicle_number' => $this->input->post('vehicle_number'),
            'customer' => $this->input->post('customer')
        );

        $total_data_item = count($this->input->post('material_code_item'));
        for ($i = 0; $i < $total_data_item; $i++) {

            $qty_item = $this->input->post('qty_item')[$i];
            $price_item = $this->input->post('price_item')[$i];
            $total = $qty_item * $price_item;

            $data_item[] = array(
                'sales_number' => $data['sales_number'],
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
                'mutation_number' => $data['sales_number'],
                'posting_date' => $data['posting_date'],
                'material_code' => $this->input->post('material_code_item')[$i],
                'move_type' => 'SLS',
                'qty' => $this->input->post('qty_item')[$i],
                'uom_code' => $this->input->post('uom_code_item')[$i],
                'price' => $this->input->post('price_item')[$i],
                'total' => $total,
                'date_added' => date('Y-m-d h:i:s')
            );
        }

        $this->db->trans_start();
        $this->db->insert($this->table, $data);
        $this->db->insert_batch('trans_sales_item', $data_item);
        $this->db->insert_batch('trans_mutation_item', $data_item_mutation);
        $this->db->trans_complete();
    }

    function is_edited()
    {

        $sales_number = $this->input->post('sales_number');
        $data = array(
            'posting_date' => $this->input->post('posting_date'),
            'vehicle_number' => $this->input->post('vehicle_number'),
            'customer' => $this->input->post('customer')
        );

        $total_data_item = count($this->input->post('material_code_item'));
        for ($i = 0; $i < $total_data_item; $i++) {

            $qty_item = $this->input->post('qty_item')[$i];
            $price_item = $this->input->post('price_item')[$i];
            $total = $qty_item * $price_item;

            $data_item[] = array(
                'sales_number' => $sales_number,
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
                'mutation_number' => $sales_number,
                'posting_date' => $data['posting_date'],
                'material_code' => $this->input->post('material_code_item')[$i],
                'move_type' => 'SLS',
                'qty' => $this->input->post('qty_item')[$i],
                'uom_code' => $this->input->post('uom_code_item')[$i],
                'price' => $this->input->post('price_item')[$i],
                'total' => $total,
                'date_added' => date('Y-m-d h:i:s')
            );
        }

        $this->db->trans_start();
        $this->db->where('sales_number', $sales_number);
        $this->db->update($this->table, $data);

        $this->db->where('sales_number', $sales_number);
        $this->db->delete('trans_sales_item');

        $this->db->where('mutation_number', $sales_number);
        $this->db->delete('trans_mutation_item');

        $this->db->insert_batch('trans_sales_item', $data_item);
        $this->db->insert_batch('trans_mutation_item', $data_item_mutation);

        $this->db->trans_complete();
    }

    function getSalesData($sales_number)
    {
        $this->db->where('sales_number', $sales_number);
        return $this->db->get($this->table)->row_array();
    }

    function is_deleted($sales_number)
    {
        $this->db->trans_start();

        $this->db->where('mutation_number', $sales_number);
        $this->db->delete('trans_mutation_item');

        $this->db->where('sales_number', $sales_number);
        $this->db->delete('trans_sales_item');

        $this->db->where('sales_number', $sales_number);
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

    function getSalesDataItem($sales_number)
    {
        return $this->db->query("SELECT 
            sls.sales_number AS sales_number,
            sls.material_code AS material_code,
            mat.material_description AS material_description,
            mat.uom_code AS uom_code,
            sls.qty,
            sls.price
            FROM trans_sales_item AS sls JOIN ms_material AS mat ON sls.material_code=mat.material_code 
            WHERE sls.sales_number='" . $sales_number . "'")->result_array();
    }

    function generateSalesNumber(){
        $this->db->select('MAX(RIGHT(sales_number,6)) AS total');
        $counter = $this->db->get($this->table)->row_array();
        return 'SL'.str_pad((int) $counter['total'] + 1,'6',0,STR_PAD_LEFT);
    }

    function getCustomerList()
    {
        return $this->db->get('ms_customer')->result_array();
    }

    function getSalesDataPrint($sales_number)
    {
        $this->db->select('sl.*,cus.customer_name,cus.address');
        $this->db->from($this->table.' AS sl');
        $this->db->join('ms_customer AS cus','sl.customer=cus.customer_code','left');
        $this->db->where('sl.sales_number', $sales_number);
        return $this->db->get()->row_array();
    }
}
