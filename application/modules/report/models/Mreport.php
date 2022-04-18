<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mreport extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->database();
    }

    function getMonthStock($stock_date)
    {

        $date1 = substr($stock_date, 0, 7) . '-01';

        return $this->db->query("
            SELECT 
                mi.material_code,
                mat.material_description,
                mi.uom_code,
                (SUM(IF(move_type IN ('GR') AND posting_date < '" . $date1 . "',qty,0)) - SUM(IF(move_type IN ('SLS') AND posting_date < '" . $date1 . "',qty,0))) AS beg_stock,
                SUM(IF(move_type IN ('GR'),qty,0)) AS stock_in,
                SUM(IF(move_type IN ('SLS'),qty,0)) AS stock_out
            FROM 
                trans_mutation_item AS mi LEFT JOIN ms_material AS mat ON mi.material_code=mat.material_code
            WHERE 
                posting_date BETWEEN '" . $date1 . "' AND '" . $stock_date . "'
            GROUP BY 
                mi.material_code,mi.uom_code
        ")->result_array();
    }

    function getDayStock($stock_date)
    {
        return $this->db->query("
            SELECT 
                mi.material_code,
                mi.mutation_number,
                mat.material_description,
                mi.uom_code,
                mi.move_type,
                mi.qty
            FROM 
                trans_mutation_item AS mi LEFT JOIN ms_material AS mat ON mi.material_code=mat.material_code
            WHERE 
                posting_date = '" . $stock_date . "'
        ")->result_array();
    }

    function getSalesReport($date_from, $date_to)
    {
        return $this->db->query("
            SELECT
                inv.invoice_number,
                inv.posting_date,
                cus.customer_name,
                SUM(IF(inv.posting_date >= '" . $date_from . "' AND inv.posting_date <= '" . $date_to . "',item.total,0)) AS sales_total,
                (SELECT SUM(total_payment) FROM trans_invoice_payment WHERE invoice_number=inv.invoice_number AND payment_date BETWEEN '" . $date_from . "' AND '" . $date_to . "') AS total_payment
            FROM 
                trans_invoice AS inv INNER JOIN trans_invoice_item AS item ON inv.invoice_number=item.invoice_number
                LEFT JOIN trans_invoice_payment AS pay ON inv.invoice_number=pay.invoice_number
                LEFT JOIN ms_customer AS cus ON inv.customer=cus.customer_code
            WHERE 
                inv.posting_date BETWEEN '" . $date_from . "' AND '" . $date_to . "'
            GROUP BY 
                inv.invoice_number
            ORDER BY
                inv.posting_date
        ")->result_array();
    }

    function getSalesProductPreview($date_from, $date_to)
    {
        $data['head'] = $this->db->query("
        SELECT 
            inv.*,cus.customer_name FROM trans_invoice AS inv LEFT JOIN ms_customer AS cus ON inv.customer=cus.customer_code
        WHERE inv.posting_date BETWEEN '" . $date_from . "' AND '" . $date_to . "'
        ORDER BY inv.invoice_number
        ")->result_array();

        $data['item'] = $this->db->query("
            SELECT 
                inv.*,item.*,mat.material_description
            FROM 
                trans_invoice AS inv INNER JOIN trans_invoice_item AS item ON inv.invoice_number=item.invoice_number
                LEFT JOIN ms_material AS mat ON item.material_code=mat.material_code
            WHERE 
                inv.posting_date BETWEEN '" . $date_from . "' AND '" . $date_to . "'
         ")->result_array();


        return $data;
    }

    function getFakturProductPreview($date_from, $date_to)
    {
        $data['head'] = $this->db->query("
        SELECT 
            fk.*,sup.supplier_name FROM trans_faktur AS fk LEFT JOIN ms_supplier AS sup ON fk.supplier=sup.supplier_code
        WHERE fk.posting_date BETWEEN '" . $date_from . "' AND '" . $date_to . "'
        ORDER BY fk.faktur_number
        ")->result_array();

        $data['item'] = $this->db->query("
            SELECT 
                fk.*,item.*,mat.material_description
            FROM 
                trans_faktur AS fk INNER JOIN trans_faktur_item AS item ON fk.faktur_number=item.faktur_number
                LEFT JOIN ms_material AS mat ON item.material_code=mat.material_code
            WHERE 
                fk.posting_date BETWEEN '" . $date_from . "' AND '" . $date_to . "'
         ")->result_array();


        return $data;
    }
}
