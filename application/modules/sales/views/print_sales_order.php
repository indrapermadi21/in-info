
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

$pdf->SetFont('courier', '', 12);
$pdf->Cell(0, 0, 'PT. ABC', 0, 1, 'C');

$pdf->SetFont('courier', '', 8);
$pdf->Cell(0, 0, 'Jl. Raya No. 23 Phone (022) 12345678', 0, 1, 'C');
// $pdf->Cell(10,0,'PT. ABC',0);
$pdf->Ln(2);
$pdf->SetFont('courier', 'B', 10);
$pdf->Cell(0, 0, 'BUKTI PENGELUARAN BARANG', 0, 1, 'C');

$pdf->Ln(2);
$pdf->SetFont('courier', '', 8);

$pdf->Ln(3);

$tbl = '
<table border="0" cellspacing="0" cellpadding="2">
        <tr>
            <td width="100">No.Transaksi</td>
            <td width="10">:</td>
            <td width="150" >' . $result['sales_number'] . '</td>
            <td width="100" rowspan="3">Kepada</td>
            <td width="10" rowspan="3">:</td>
            <td width="190" rowspan="3" >' . $result['customer_name'] . '<br>' . $result['address'] . '</td>
        </tr>
        <tr>
            <td >Tanggal</td>
            <td>:</td>
            <td>' . $result['posting_date'] . '</td>
            
        </tr>
        <tr>
            <td>No. Kendaraan</td>
            <td>:</td>
            <td>' . $result['vehicle_number'] . '</td>
            
        </tr>
    </table>
';

$pdf->writeHTML($tbl, true, false, false, false, '');

$html = '
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            <td style="text-align:center;width:50"><strong>No</strong></td>
            <td style="text-align:center;width:75"><strong>Kode Material</strong></td>
            <td style="text-align:center;width:250"><strong>Deskripsi</strong></td>
            <td style="text-align:center;width:65"><strong>Satuan</strong></td>
            <td style="text-align:center;width:125"><strong>Jumlah</strong></td>
        </tr>';

$i = 1;
foreach ($result_item as $row) {
    $html .= '
            <tr>
                <td style="text-align: center;">' . $i . '</td>
                <td style="text-align: center;">' . $row['material_code'] . '</td>
                <td style="text-align: left;">' . $row['material_description'] . '</td>
                <td style="text-align: center;">' . $row['uom_code'] . '</td>
                <td style="text-align: center;">' . number_format($row['qty'], 0) . '</td>
            </tr>
        ';
    $i++;
}
$html .= '   </table>';
$pdf->writeHTML($html, true, false, false, false, '');
$pdf->Ln(1);

$foot ='
    <table >
        <tr>
            <td style="text-align: center;">Penerima</td>
            <td>&nbsp;</td>
            <td style="text-align: center;">Pengirim</td>
            <td>&nbsp;</td>
            <td style="text-align: center;">Mengetahui</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align: center;">(....................)</td>
            <td>&nbsp;</td>
            <td style="text-align: center;">(....................)</td>
            <td>&nbsp;</td>
            <td style="text-align: center;">(....................)</td>
        </tr>
    </table>
';

$pdf->writeHTML($foot, true, false, false, false, '');
ob_end_clean();
$pdf->Output('Bukti Pengeluaran Barang.pdf', 'I');
