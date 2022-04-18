<?php

$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Faktur Pembelian Barang');

// set header
// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->SetMargins(5, 5, 5);
// $pdf->SetTopMargin(20);
// $pdf->setFooterMargin(20);
$pdf->SetAutoPageBreak(true, 15);
$pdf->SetAuthor('Author');
// $pdf->SetDisplayMode('real', 'default');
$pdf->setPrintHeader(false);
$pdf->AddPage();


$pdf->SetFont('courier', 'B', 10);
$pdf->Cell(0, 0, 'Laporan Pembelian Produk', 0, 1, 'C');

$pdf->SetFont('courier', '', 8);
$pdf->Cell(0, 0, 'Periode ' . $date_from . ' Sampai ' . $date_to, 0, 1, 'C');


$pdf->Ln(2);
$pdf->SetFont('courier', '', 8);

$pdf->Ln(3);
$html .= '<table cellpadding="1" >
    <tr>
        <td style="text-align: center;" colspan="4"><strong>FAKTUR</strong></td>
        <td colspan="3"><strong>PT. ABC<br>
                Jl. Raya No. 23 Phone (022) 12345678</strong></td>
    </tr>
    <tr>
        <td colspan="7">&nbsp;</td>
    </tr>
    <tr>
        <td style="width: 75;">Dari</td>
        <td style="width: 10;">:</td>
        <td style="width: 150">' . $results['supplier_name'] . '</td>
        <td>&nbsp;</td>
        <td style="width: 100">No. Invoice</td>
        <td style="width: 10">:</td>
        <td style="width: 150">' . $results['faktur_number'] . '</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Tanggal</td>
        <td>:</td>
        <td>' . $results['posting_date'] . '</td>
    </tr>
</table>
<br><br>
<table cellpadding="2" border="1" style="border-collapse: collapse;">
    <tr>
        <td width="40" style="text-align: center;"><strong>No</strong></td>
        <td width="75" style="text-align: center;"><strong>Kode Material</strong></td>
        <td width="150" style="text-align: center;"><strong>Deskripsi</strong></td>
        <td width="40" style="text-align: center;"><strong>Satuan</strong></td>
        <td width="50" style="text-align: center;"><strong>Jumlah</strong></td>
        <td width="80" style="text-align: center;"><strong>Harga</strong></td>
        <td width="100" style="text-align: center;"><strong>Total</strong></td>
    </tr>';

$i = 1;
$total = 0;
foreach ($results_item as $row) :
    $html .= '<tr>
            <td style="text-align: center;">' . $i . '</td>
            <td>' . $row['material_code'] . '</td>
            <td>' . $row['material_description'] . '</td>
            <td style="text-align: center;">' . $row['uom_code'] . '</td>
            <td style="text-align: center;">' . number_format($row['qty'], 0) . '</td>
            <td style="text-align: right;">' . number_format($row['price'], 0) . '</td>
            <td style="text-align: right;">' . number_format($row['total'], 0) . '</td>
        </tr>';

    $total += $row['total'];
    $i++;
endforeach;
$html .= ' <tr>
        <td colspan="6" style="text-align: right;"><strong>Total</strong></td>
        <td style="text-align: right;"><strong>Rp. ' . number_format($total, 0) . '</strong></td>
    </tr>
</table>';

$pdf->writeHTML($html, true, false, false, false, '');
ob_end_clean();
$pdf->Output('Laporan Pembelian Produk.pdf', 'I');
