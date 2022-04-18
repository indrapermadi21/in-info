<?php

class Mdashboard extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getContract()
    {
        $this->db->select("
            SUM(IF(status_val='PLANORD',1,0)) AS plan_order,
            SUM(IF(status_val='OSC',1,0)) AS osc,
            SUM(IF(status_val='POUN',1,0)) AS poun,
        ");
        return $this->db->get('mrp_contract')->row();
    }

    public function getPoGr()
    {

        $this->db->select("max(created_date) AS created_data");
        $data = $this->db->get('mrp_data')->row('created_data');

        $this->db->select("
            SUM(IF(value='PO',qty,0)) AS po,
            SUM(IF(value='GR',qty,0)) AS gr
        ");
        $this->db->where('created_date', $data);
        return $this->db->get('mrp_data')->row();
    }

    public function getPlanData()
    {
        $this->db->where('status_val', 'PLANORD');
        return $this->db->get('mrp_contract')->result();
    }

    public function getOsContract()
    {
        $this->db->where('status_val', 'OSC');
        return $this->db->get('mrp_contract')->result();
    }

    public function getPoUn()
    {
        $this->db->where('status_val', 'POUN');
        return $this->db->get('mrp_contract')->result();
    }
}
