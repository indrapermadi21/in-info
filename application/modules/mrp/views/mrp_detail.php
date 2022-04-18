<html>
    <body>
        <h3>Data MRP</h3>
        <table style="border-collapse: collapse;" border="1" width="100%" cellpadding="3px">
            <tr>
                <th>Mat. Code</th>
                <th>Description</th>
                <th>Bun</th>
                <th>Price</th>
                <th>Year</th>
                <th>Month</th>
                <th>Week</th>
                <th>Qty</th>
                <th>Amount</th>
                <th>Prch Doc</th>
                <th>Vendor Accuont</th>
            </tr>
            <?php
                $i =1;
                foreach($result as $r):
            ?>
            <tr>
                <td style="text-align: center;"><?= $r->material_code?> </td>
                <td><?= $r->material_description?> </td>
                <td style="text-align: center;"><?= $r->bun?> </td>
                <td style="text-align: right;"><?= number_format($r->price)?> </td>
                <td style="text-align: center;"><?= $r->year?> </td>
                <td style="text-align: center;"><?= $r->month?> </td>
                <td style="text-align: center;"><?= $r->week?> </td>
                <td style="text-align: right;"><?= number_format($r->qty)?> </td>
                <td style="text-align: right;"><?= number_format($r->amount)?> </td>
                <td><?= $r->prch_doc?> </td>
                <td><?= $r->vendor_account?> </td>
            </tr>
            <?php
                endforeach;
            ?>

        </table>
    </body>
</html>