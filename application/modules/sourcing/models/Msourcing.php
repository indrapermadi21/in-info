<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Msourcing extends CI_Model
{

    var $table = 'mrp_sourcing';
    var $column_order = array('id','image','material_code', 'material_description', 'material_group', 'vendor_account', 'ldt', 'std_doi','moq', null);
    var $column_search = array('id','image','material_code', 'material_description', 'material_group', 'vendor_account', 'ldt', 'std_doi','moq');
    var $order = array('material_code' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_query_sourcing()
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

    function get_sourcing()
    {
        $d = $this->_get_query_sourcing();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();

        // echo $this->db->last_query();

        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_query_sourcing();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function getSourcingData($id)
    {
        $this->db->from($this->table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function is_saved()
    {
        $config['upload_path']          = './upload/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 1000;
        $config['max_width']            = 6000;
        $config['max_height']           = 6000;

        $this->load->library('upload', $config);

        $this->db->trans_start();

        if (!$this->upload->do_upload('image')) {
            if ($_FILES['image']['name'] != "") {
                $this->session->set_flashdata("message_error", $this->upload->display_errors());
                redirect('sourcing/sourcing_add');
                exit;
            }
        }

        $data = array(

            'material_code' => $this->input->post('material_code'),
            'material_description' => $this->input->post('material_description'),
            'material_group' => $this->input->post('material_group'),
            'vendor_account' => $this->input->post('vendor_account'),
            'ldt' => $this->input->post('ldt'),
            'std_doi' => $this->input->post('std_doi'),
            'moq' => $this->input->post('moq')
        );

        if ($this->upload->data('file_name')) {
            $data['image'] = $this->upload->data('file_name');
        }

        $this->db->insert($this->table, $data);

        $this->db->trans_complete();
    }

    function is_edited()
    {

        $config['upload_path']          = './upload/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 1000;
        $config['max_width']            = 6000;
        $config['max_height']           = 6000;
        $config['overwrite']            = TRUE;

        $this->load->library('upload', $config);

        $id = $this->input->post('id');

        $this->db->trans_start();

        if (!$this->upload->do_upload('image')) {
            if ($_FILES['image']['name'] != "") {
                $this->session->set_flashdata("message_error", $this->upload->display_errors());
                redirect('sourcing/sourcing_edit/' . $id);
                exit;
            }
        }

        $data = array(
            'material_code' => $this->input->post('material_code'),
            'material_description' => $this->input->post('material_description'),
            'material_group' => $this->input->post('material_group'),
            'vendor_account' => $this->input->post('vendor_account'),
            'ldt' => $this->input->post('ldt'),
            'std_doi' => $this->input->post('std_doi'),
            'moq' => $this->input->post('moq')
        );

        if ($this->upload->data('file_name')) {
            $data['image'] = $this->upload->data('file_name');
        }

        $this->db->where('id', $id);
        $this->db->update($this->table, $data);

        $this->db->trans_complete();
    }

    function is_deleted($id)
    {
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->delete($this->table);
        $this->db->trans_complete();
        return true;
    }
}
