<html>

<head>
    <title>Laporan Stok</title>
</head>

<body>
    <div style="text-align: center;">
        <strong>Laporan Stok</strong><br>
        <?= $date_from ?> Sampai <?= $date_to ?>
    </div>
    <br>
    <br>
    <table style="width: 100%;border-collapse: collapse;" border="1" cellpadding="3px">
        <tr>
            <td style="text-align: center;" rowspan="2"><strong>No.</td>
            <td style="text-align: center;" rowspan="2"><strong>Kode Material</td>
            <td style="text-align: center;" rowspan="2"><strong>Deskripsi</td>
            <td style="text-align: center;" rowspan="2"><strong>Satuan</td>
            <td style="text-align: center;" rowspan="2"><strong>Saldo Awal</td>
            <td style="text-align: center;" colspan="2"><strong>Stok</td>
            <td style="text-align: center;" rowspan="2"><strong>Saldo Akhir</td>
        </tr>
        <tr>
            <td style="text-align: center;"><strong>Pembelian</strong></td>
            <td style="text-align: center;"><strong>Penjualan</strong></td>
        </tr>
        <?php
        $i = 1;
        foreach ($results as $row) :
            $end_stock = $row['beg_stock'] + $row['stock_in'] - $row['stock_out'];

        ?>
            <tr>
                <td style="text-align: center;"><?= $i ?></td>
                <td style="text-align: center;"><?= $row['material_code'] ?></td>
                <td><?= $row['material_description'] ?></td>
                <td style="text-align: center;"><?= $row['uom_code'] ?></td>
                <td style="text-align: right;"><?= number_format($row['beg_stock'], 0) ?></td>
                <td style="text-align: right;"><?= number_format($row['stock_in'], 0) ?></td>
                <td style="text-align: right;"><?= number_format($row['stock_out'], 0) ?></td>
                <td style="text-align: right;"><?= number_format($end_stock, 0) ?></td>
            </tr>
        <?php
            $i++;
        endforeach;
        ?>
    </table>
</body>

</html>