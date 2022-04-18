<?php

$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetTitle('Bukti Pengeluaran Barang');

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
$pdf->Cell(0, 0, 'Laporan Penjualan Produk', 0, 1, 'C');

$pdf->SetFont('courier', '', 8);
$pdf->Cell(0, 0, 'Periode ' . $date_from . ' Sampai ' . $date_to, 0, 1, 'C');


$pdf->Ln(2);
$pdf->SetFont('courier', '', 8);

$pdf->Ln(3);
$html .= '
    <table border="1" cellpadding="3" cellspacing="0">
    <tr>
        <th style="text-align:center" width="50" ><strong>Invoice</strong></th>
        <th style="text-align:center" width="60" ><strong>Tanggal</strong></th>
        <th style="text-align:center" width="190" ><strong>Pelanggan</strong></th>
        <th style="text-align:center" width="50"><strong>Jumlah</strong></th>
        <th style="text-align:center" width="40"><strong>Satuan</strong></th>
        <th style="text-align:center" width="80"><strong>Harga</strong></th>
        <th style="text-align:center" width="100"><strong>Total</strong></th>

    </tr>
    ';

$total = 0;
foreach ($results['head'] as $row) :

    $html .= '
        <tr nobr="true">
            <td style="text-align:center">' . $row['invoice_number'] . '</td>
            <td style="text-align:center">' . $row['posting_date'] . '</td>
            <td >' . $row['customer_name'] . '</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
        </tr>
        ';
    $sub_total = 0;
    foreach ($results['item'] as $r) :
        if ($r['invoice_number'] == $row['invoice_number']) {

            $html .= '     
               <tr>
                    <td>&nbsp;</td>
                    <td colspan="2">' . $r['material_description'] . '</td>
                    <td style="text-align:center" >' . number_format($r['qty'], 0) . '</td>
                    <td>' . $r['uom_code'] . '</td>
                    <td style="text-align:right">' . number_format($r['price'], 0) . '</td>
                    <td style="text-align:right">' . number_format($r['total'], 0) . '</td>
                </tr>';

            $sub_total += $r['total'];
        }
    endforeach;

    $html .= '        <tr>
            <td style="text-align:right" colspan="6" ><strong>Sub Total</strong></td>
            <td style="text-align:right" ><strong>' . number_format($sub_total, 0) . '</strong></td>
        </tr>';

    $total += $sub_total;
endforeach;

$html .= '<tr>
    <td colspan="7">&nbsp;</td>
</tr>
<tr>
    <td style="text-align:right" colspan="6" ><strong>Total</strong></td>
    <td style="text-align:right" ><strong>' . number_format($total, 0) . '</strong></td>
</tr>
</table>';


$pdf->writeHTML($html, true, false, false, false, '');
ob_end_clean();
$pdf->Output('Laporan Penjualan Produk.pdf', 'I');
