<html>

<head>
    <title>Laporan Pembelian Produk</title>
    <style>
        table {
            width: 100%;
            /* border: solid 1px; */
            font-size: 0.9em;
            font-family: 'Courier New', Courier, monospace;
        }
        table tr th {
            padding: 6px;
            border-top: solid 1px;
            border-bottom: solid 1px;
            border-collapse: collapse;
            /* border: solid 1px; */
        }
        table tr td {
            padding: 3px;
            /* border: solid 1px; */
        }

        .border_top {
            border-top: solid 1px;
            border-collapse: collapse;
        }

        .border_bold {
            padding: 8px;
            border-top: double;
            border-bottom: double;
        }

        /* .border_top_bot {
            padding: 8px;
            border-top: solid;
            border-bottom: solid;
        } */

        .style_head{
            font-family: 'Courier New', Courier, monospace;
        }
    </style>
</head>

<body>
    <div style="text-align: center;">
        <strong><div class="style_head"><h3>Laporan Pembelian Produk</h3></strong>
        <?= $date_from ?> Sampai <?= $date_to ?></div>
    </div>
    <br>
    <table>
        <tr>
            <th style="text-align: center;"><strong>Faktur</strong></th>
            <th style="text-align: center;" colspan="2"><strong>Tanggal</strong></th>
            <th style="text-align: center;" colspan="3"><strong>Supplier</strong></th>
        </tr>
        <?php
        $total = 0;
        foreach ($results['head'] as $row) :
        ?>
            <tr>
                <td style="text-align: center;"><?= $row['faktur_number'] ?></td>
                <td colspan="2"><?= $row['posting_date'] ?></td>
                <td coslpan="3"><?= $row['supplier_name'] ?></td>
            </tr>
            <?php
            $sub_total = 0;
            foreach ($results['item'] as $r) :
                if ($r['faktur_number'] == $row['faktur_number']) {
            ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td style="text-align: left;"><?= $r['material_code'].' '.$r['material_description'] ?></td>
                        <td style="text-align: right;"><?= number_format($r['qty'], 0) ?></td>
                        <td style="text-align: center;"><?= $r['uom_code'] ?></td>
                        <td style="text-align: right;"><?= number_format($r['price'], 0) ?></td>
                        <td style="text-align: right;"><?= number_format($r['total'], 0) ?></td>
                    </tr>
            <?php
                    $sub_total += $r['total'];
                }
            endforeach;
            ?>
            <tr>
                <td colspan="5" style="text-align: right;"><strong>Sub Total</strong></td>
                <td style="text-align: right;" class="border_top"><strong><?= number_format($sub_total, 0) ?></strong></td>
            </tr>
        <?php
            $total += $sub_total;
        endforeach;
        ?>
        <tr>
            <td colspan="6">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="5" style="text-align: right;"><strong>Total</strong></td>
            <td style="text-align: right;" class="border_bold"><strong><?= number_format($total, 0) ?></strong></td>
        </tr>

    </table>
</body>

</html>