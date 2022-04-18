<html>

<head>
    <title>Laporan Penjualan</title>
</head>

<body>
    <div style="text-align: center;">
        <strong>Laporan Penjualan</strong><br>
        <?= $date_from ?> Sampai <?= $date_to ?>
    </div>
    <br>
    <br>
    <table style="width: 100%;border-collapse: collapse;" border="1" >
        <tr>
            <th style="text-align: center;padding:5px" ><strong>Tanggal</th>
            <th style="text-align: center;padding:5px" ><strong>Invoice</th>
            <th style="text-align: center;padding:5px" ><strong>Pelanggan</th>
            <th style="text-align: center;padding:5px" ><strong>Penjualan</th>
            <th style="text-align: center;padding:5px" ><strong>Pembayaran</th>
            <th style="text-align: center;padding:5px" ><strong>Saldo</th>
        </tr>
        <?php
        $sub_total = 0;
        $total = 0;
        $sub_total_sales = 0;
        $sub_total_payment =0;
        $sub_total_saldo = 0;
        
        foreach ($results as $row) :
            $total = $row['sales_total'] - $row['total_payment'];
        ?>
            <tr>
                <td style="text-align: center;padding:4px"><?= $row['posting_date'] ?></td>
                <td style="text-align: center;padding:4px"><?= $row['invoice_number'] ?></td>
                <td style="text-align: left;padding:4px"><?= $row['customer_name'] ?></td>
                <td style="text-align: right;padding:4px"><?= number_format($row['sales_total'], 0) ?></td>
                <td style="text-align: right;padding:4px"><?= number_format($row['total_payment'], 0) ?></td>
                <td style="text-align: right;padding:4px"><?= number_format($total, 0) ?></td>
            </tr>
        <?php
            $sub_total += $total;
            $sub_total_sales += $row['sales_total'];
            $sub_total_payment += $row['total_payment'];
        endforeach;
        ?>
        <tr >
            <td style="text-align: center;padding:10px" colspan="3"><strong>Total</strong></td>
            <td style="text-align: right;padding:10px"><strong><?= number_format($sub_total_sales,0)?></strong></td>
            <td style="text-align: right;padding:10px"><strong><?= number_format($sub_total_payment,0)?></strong></td>
            <td style="text-align: right;padding:10px"><strong><?= number_format($sub_total,0)?></strong></td>
        </tr>
    </table>
</body>

</html>