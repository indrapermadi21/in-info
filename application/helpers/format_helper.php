<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('test_method')) {
    function changeDate($date = '')
    {
        return substr($date, -2) . '/' . substr($date, 5, 2) . '/' . substr($date, 0, 4);
    }

    function yearMonthPlus($year_month)
    {
        $year = substr($year_month, 0, 4);
        $month = substr($year_month, -2);

        if ($month == '12') {
            $month = '01';
            $year = $year + 1;
        } else {
            $month = $month + 1;
        }

        return $year . '-' . str_pad($month, 2, "0", STR_PAD_LEFT);
    }

    function changeMoveType($move_type)
    {
        switch ($move_type) {
            case 'GR':
                return 'Goods Receive';
                break;
            case 'SLS':
                return 'Sales';
                break;
        }
    }
}
