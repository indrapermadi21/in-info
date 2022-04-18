<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Minvoice extends CI_Model
{

    var $table = 'trans_invoice';
    var $column_order = array('invoice_number', 'posting_date', 'reference_number','due_date','payment_date', 'customer_name','total', null);
    var $column_search = array('invoice_number', 'posting_date', 'reference_number', 'due_date','payment_date','customer_name','total');
    var $order = array('invoice_number' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_query_invoice()
    {

        $this->db->select("inv.*,SUM(it.total) AS total,cus.customer_name");
        $this->db->from($this->table.' AS inv');
        $this->db->join('trans_invoice_item AS it','inv.invoice_number=it.invoice_number');
        $this->db->join('ms_customer AS cus','cus.customer_code=inv.customer','left');

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

        $this->db->group_by('invoice_number');
        $this->db->having('total <> 0');

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_invoice()
    {
        $d = $this->_get_query_invoice();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_query_invoice();
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
            'invoice_number' => $this->input->post('invoice_number'),
            'posting_date' => $this->input->post('posting_date'),
            'reference_number' => $this->input->post('reference_number'),
            'ref_date' => $this->input->post('ref_date'),
            'customer' => $this->input->post('customer'),
            'due_date' => $this->input->post('due_date'),
            'status_payment' => '0',
            'date_added' => date('Y-m-d h:i:s')
        );

        $query_item = $this->db->query("SELECT * FROM trans_sales_item WHERE sales_number='".$data['reference_number']."'")->result();
        foreach($query_item as $row){
            $data_item[] = array(
                'invoice_number' => $data['invoice_number'],
                'material_code' => $row->material_code,
                'qty' => $row->qty,
                'uom_code' => $row->uom_code,
                'price' => $row->price,
                'total' => $row->total,
                'date_added' => date('Y-m-d h:i:s')
            );
        }
        
        $this->db->trans_start();
        $this->db->insert($this->table, $data);
        $this->db->insert_batch('trans_invoice_item', $data_item);
        $this->db->trans_complete();
    }

    function is_edited()
    {

        $invoice_number = $this->input->post('invoice_number');
        $data = array(
            'posting_date' => $this->input->post('posting_date'),
            'reference_number' => $this->input->post('reference_number'),
            'ref_date' => $this->input->post('ref_date'),
            'customer' => $this->input->post('customer'),
            'status_payment' => '0',
            'due_date' => $this->input->post('due_date'),
            'date_modified' => date('Y-m-d h:i:s')
        );

        $query_item = $this->db->query("SELECT * FROM trans_sales_item WHERE sales_number='".$data['reference_number']."'")->result();
        foreach($query_item as $row){
            $data_item[] = array(
                'invoice_number' => $invoice_number,
                'material_code' => $row->material_code,
                'qty' => $row->qty,
                'uom_code' => $row->uom_code,
                'price' => $row->price,
                'total' => $row->total,
                'date_added' => date('Y-m-d h:i:s')
            );
        }

        $this->db->trans_start();
        $this->db->where('invoice_number', $invoice_number);
        $this->db->update($this->table, $data);

        $this->db->where('invoice_number', $invoice_number);
        $this->db->delete('trans_invoice_item');

        $this->db->insert_batch('trans_invoice_item', $data_item);

        $this->db->trans_complete();
    }

    function getInvoiceData($invoice_number)
    {
        $this->db->select('inv.*,cus.customer_name,cus.address');
        $this->db->from($this->table.' AS inv');
        $this->db->join('ms_customer AS cus','inv.customer=cus.customer_code','left');
        $this->db->where('inv.invoice_number', $invoice_number);
        return $this->db->get()->row_array();
    }

    function is_deleted($invoice_number)
    {
        $this->db->trans_start();

        $this->db->where('invoice_number', $invoice_number);
        $this->db->delete('trans_invoice_item');

        $this->db->where('invoice_number', $invoice_number);
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

    function getInvoiceDataItem($invoice_number)
    {
        return $this->db->query("SELECT 
            inv.invoice_number AS invoice_number,
            inv.material_code AS material_code,
            mat.material_description AS material_description,
            mat.uom_code AS uom_code,
            inv.qty,
            inv.price,
            inv.total
            FROM trans_invoice_item AS inv JOIN ms_material AS mat ON inv.material_code=mat.material_code 
            WHERE inv.invoice_number='" . $invoice_number . "'")->result_array();
    }

    function generateInvoiceNumber()
    {
        $this->db->select('MAX(RIGHT(invoice_number,6)) AS total');
        $counter = $this->db->get($this->table)->row_array();
        return 'INV' . str_pad((int) $counter['total'] + 1, '6', 0, STR_PAD_LEFT);
    }

    function getSalesData()
    {
        $sales_number = $this->input->post('reference_number');
        $this->db->where('sales_number', $sales_number);
        $data['head'] = $this->db->get('trans_sales')->row();


        $this->db->select('si.*,mat.material_description');
        $this->db->from('trans_sales_item AS si');
        $this->db->join('ms_material AS mat', 'mat.material_code = si.material_code','LEFT');
        $this->db->where('si.sales_number', $sales_number);
        $data['item'] = $this->db->get()->result();

        return $data;
    }

    function getInvoicePayment($invoice_number)
    {
        $this->db->select('inv.*,SUM(it.total) AS total_amount');
        $this->db->from($this->table.' AS inv');
        $this->db->join('trans_invoice_item AS it','inv.invoice_number=it.invoice_number');
        $this->db->where('inv.invoice_number', $invoice_number);
        return $this->db->get()->row_array();
    }

    function getPaymentNumber(){
        $this->db->select('MAX(RIGHT(payment_number,6)) AS total');
        $counter = $this->db->get('trans_invoice_payment')->row_array();
        return 'PAY' . str_pad((int) $counter['total'] + 1, '6', 0, STR_PAD_LEFT);
    }

    function getPaymentData($invoice_number){
        $this->db->where('invoice_number',$invoice_number);
        return $this->db->get('trans_invoice_payment')->result_array();
    }

    function is_payment(){
        
        $data = array(
            'payment_number' => $this->input->post('payment_number'),
            'invoice_number' => $this->input->post('invoice_number'),
            'payment_date' => $this->input->post('payment_date'),
            'total_payment' => $this->input->post('total_payment')
        );

        $invoice_total = $this->input->post('total_amount');
        if($invoice_total==$data['total_payment']){
            // payment finish 
            $status = '2';
        } else {
            // not payment
            $status = '0';
        }
        

        $data_invoice = array(
            'payment_date' => $data['payment_date'],
            'status_payment' => $status,
            'date_modified' => date('Y-m-d h:i:s')
        );


        $this->db->trans_start();
        
        $this->db->insert('trans_invoice_payment', $data);

        $this->db->where('invoice_number', $data['invoice_number']);
        $this->db->update($this->table, $data_invoice);
        
        $this->db->trans_complete();


    }

    
}
