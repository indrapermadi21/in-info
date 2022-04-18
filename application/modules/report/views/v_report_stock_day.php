<html>

<head>
    <title>Laporan Stok</title>
</head>

<body>
    <div style="text-align: center;">
        <strong>Laporan Stok Harian</strong><br>
        <?= $date_to ?>
    </div>
    <br>
    <br>
    <table style="width: 100%;border-collapse: collapse;" border="1" cellpadding="5px">
        <tr>
            <td style="text-align: center;"><strong>No.</td>
            <td style="text-align: center;"><strong>No. Transaksi</td>
            <td style="text-align: center;"><strong>Kode Material</td>
            <td style="text-align: center;"><strong>Deskripsi</td>
            <td style="text-align: center;"><strong>Satuan</td>
            <td style="text-align: center;"><strong>Tipe</td>
            <td style="text-align: center;"><strong>Jumlah</td>
        </tr>
        <?php
        $i = 1;
        foreach ($results as $row) :

        ?>
            <tr>
                <td style="text-align: center;"><?= $i ?></td>
                <td style="text-align: center;"><?= $row['mutation_number'] ?></td>
                <td style="text-align: center;"><?= $row['material_code'] ?></td>
                <td><?= $row['material_description'] ?></td>
                <td style="text-align: center;"><?= $row['uom_code'] ?></td>
                <td style="text-align: center;"><?= changeMoveType($row['move_type']) ?></td>
                <td style="text-align: right;"><?= number_format($row['qty'], 0) ?></td>
            </tr>
        <?php
            $i++;
        endforeach;
        ?>
    </table>
</body>

</html>