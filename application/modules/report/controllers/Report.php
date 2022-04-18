<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mreport', 'report');
    }

    function stock()
    {
        $this->template->load('maintemplate', 'report/views/v_report');
    }

    function stock_preview($stock_date = '', $stock_type = '')
    {
        $data['date_from'] = substr($stock_date, 0, 7) . '-01';
        $data['date_to'] = $stock_date;

        switch ($stock_type) {
            case 'month':
                $data['results'] = $this->report->getMonthStock($stock_date);
                $this->load->view('v_report_stock_month', $data);
                break;
            case 'day':
                $data['results'] = $this->report->getDayStock($stock_date);
                $this->load->view('v_report_stock_day', $data);
                break;
            default:
                $data['results'] = $this->report->getMonthStock($stock_date);
                $this->load->view('v_report_stock_month', $data);
        }
    }

    function finance_report()
    {
        $this->template->load('maintemplate', 'report/views/v_report_finance');
    }

    function finance_preview($date_from = '', $date_to = '', $finance_type = '')
    {
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;

        switch ($finance_type) {
            case 'gr_detail':
                $data['results'] = $this->report->getFakturProductPreview($date_from, $date_to);
                $this->load->view('print/v_report_fproduct', $data);
                break;
            case 'sales_detail':
                $data['results'] = $this->report->getSalesProductPreview($date_from, $date_to);
                $this->load->view('print/v_report_sproduct', $data);
                break;
            default:
                $data['results'] = $this->report->getSalesReport($date_from, $date_to);
                $this->load->view('v_report_sales_print', $data);
        }
    }

    function finance_preview_pdf($date_from = '', $date_to = '', $finance_type = '')
    {
        $data['date_from'] = $date_from;
        $data['date_to'] = $date_to;

        switch ($finance_type) {
            case 'gr_detail':
                $data['results'] = $this->report->getFakturProductPreview($date_from, $date_to);
                $this->load->view('print/v_report_fproduct_pdf', $data);
                break;
            case 'sales_detail':
                $data['results'] = $this->report->getSalesProductPreview($date_from, $date_to);
                $this->load->view('print/v_report_sproduct_pdf', $data);
                break;
            default:
                $data['results'] = $this->report->getSalesReport($date_from, $date_to);
                $this->load->view('v_report_sales_print', $data);
        }
    }

}
