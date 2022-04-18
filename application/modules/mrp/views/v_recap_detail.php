<table class="table table-striped table-bordered table-hover" width="100%" id="dt_employee" style="overflow-x:auto;">
    <thead>
        <tr>
            <th rowspan="2">Material</th>
            <th rowspan="2">Description</th>
            <th rowspan="2">Ldt</th>
            <th rowspan="2">Std Doi</th>
            <th rowspan="2">Month</th>
            <th colspan="11" style="text-align: center;">Value</th>
            <th hidden>Head id</th>
            <th hidden>Date</th>
            <th rowspan="2">Action</th>
        </tr>
        <tr>
            <th>Stock</th>
            <th>Requirement</th>
            <th>Actual Usage</th>
            <th>PO</th>
            <th>OS Contract</th>
            <th>Ending Stock</th>
            <th>Std Doi</th>
            <th>GR</th>
            <th>Total PO & GR</th>
            <th>Suggest Plan</th>
            <th>Plan Order</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $ending_stock = 0;
        $std_doi = 0;
        $total_pogr = 0;
        $suggest_plan = 0;
        $plan_order = 0;
        $i = 1;
        if (!$results) {
        ?>
            <tr>
                <td colspan="17" style="text-align: center;"><b>-- Data Empty --</b></td>
            </tr>
            <?php
        } else {
            $plan_order_cal = $plan_order_cal;
            $i = 1;

            $beg_stock = 0;
            $stock = 0;
            $mat_code = '';
            $x = 0;
            foreach ($results as $row) {

                if ($mat_code == $row->material_code) {

                    $stock = $row->stock + $beg_stock;

                    if ($material_code == $row->material_code && $year_month == $row->year . '-' . str_pad($row->month, 2, "0", STR_PAD_LEFT)) {
                        echo '<br>' . $x;
                        $ym = $row->year . '-' . str_pad($row->month, 2, "0", STR_PAD_LEFT);
                        $ending_stock = $beg_stock + $row->requirement + $row->actual + $row->po + $plan_order_cal;

                        $x++;
                    } else {
                        $ending_stock = $beg_stock + $row->requirement + $row->actual + $row->po;
                    }
                } elseif ($mat_code == '') {
                    // if new material mat code receive material code
                    $stock = $row->stock;
                    if ($material_code == $row->material_code && $year_month == $row->year . '-' . str_pad($row->month, 2, "0", STR_PAD_LEFT)) {
                        $ym = $row->year . '-' . str_pad($row->month, 2, "0", STR_PAD_LEFT);
                        $ending_stock = $stock + $row->requirement + $row->actual + $row->po + $plan_order_cal;
                    } else {
                        $ending_stock = $stock + $row->requirement + $row->actual + $row->po;
                    }
                    $mat_code = $row->material_code;
                } else {
                    $stock = $row->stock;
                    if ($material_code == $row->material_code && $year_month == $row->year . '-' . str_pad($row->month, 2, "0", STR_PAD_LEFT)) {
                        $ym = $row->year . '-' . str_pad($row->month, 2, "0", STR_PAD_LEFT);
                        $ending_stock = $stock + $row->requirement + $row->actual + $row->po  + $plan_order_cal;
                        // $year_month = yearMonthPlus($ym);
                    } else {
                        $ending_stock = $stock + $row->requirement + $row->actual + $row->po;
                    }
                    $mat_code = $row->material_code;
                }

                $std_doi = $row->std_doi * $row->requirement;
                $total_pogr = $row->po + $row->gr;
                $suggest_plan = $ending_stock + $std_doi;
                if (!$row->plan_order || $row->plan_order == 0) {
                    $plan_order = round($suggest_plan, -3) * 1000;
                } else {
                    $plan_order = 0;
                }

                if ($mat_code == $row->material_code) {
                    $beg_stock = $ending_stock;
                } else {
                    $beg_stock = 0;
                }

            ?>
                <tr>
                    <td><?= $row->material_code ?></td>
                    <td><?= $row->material_description ?></td>
                    <td><?= $row->ldt ?></td>
                    <td><?= $row->std_doi * 100 ?>%</td>
                    <td><?= $row->year . '-' . str_pad($row->month, 2, "0", STR_PAD_LEFT) ?></td>
                    <td><?= number_format($stock, 0) ?></td>
                    <td><?= number_format($row->requirement, 0) ?></td>
                    <td><?= number_format($row->actual) ?></td>
                    <td><?= number_format($row->po, 0) ?></td>
                    <?php
                    $row_contract = $modelMrp->checkContractStatus($row->head_id, $row->year . '-' . str_pad($row->month, 2, "0", STR_PAD_LEFT), $row->material_code);

                    if ($row_contract == 'POUN') {
                    ?>
                        <td>0</td>
                    <?php } else {
                    ?>
                        <td><?= number_format($row->os_contract, 0) ?></td>
                    <?php }
                    ?>
                    <td><?= number_format($ending_stock, 0) ?></td>
                    <td><?= number_format($std_doi, 0) ?></td>
                    <td><?= number_format($row->gr, 0) ?></td>
                    <td><?= number_format($total_pogr, 0) ?></td>
                    <?php
                    if ($suggest_plan <= 0) {
                    ?>
                        <td><?= number_format($suggest_plan, 0) ?></td>
                    <?php
                    } else {
                    ?>
                        <td style="color: red;"><?= number_format($suggest_plan, 0) ?></td>
                    <?php
                    }
                    ?>
                    <td><input type="text" class="form-control" id="plan_order<?= $i ?>" name="plan_order" value=""></td>
                    <td hidden><?= $row->head_id ?></td>
                    <td hidden><?= $created_date ?></td>
                    <?php
                    if ($modelMrp->checkContract($row->head_id, $row->year . '-' . str_pad($row->month, 2, "0", STR_PAD_LEFT), $row->material_code)) {

                    ?>
                        <td>
                            &nbsp;
                        </td>
                    <?php
                    } else {
                    ?>
                        <td>
                            <button type="button" onclick="calculate(this)" class="btn btn-info">Calculate</button>
                            <button type="button" onclick="purpose_data(this)" class="btn btn-success">Propose</button>

                        </td>
                    <?php }
                    ?>
                </tr>
        <?php
                $i++;
            }
        }
        ?>
    </tbody>
</table>

<script type="text/javascript">
    function calculate(el) {
        let material_code = el.parentNode.parentNode.cells[0].innerHTML;
        let std_doi = el.parentNode.parentNode.cells[3].innerHTML;
        let stock = el.parentNode.parentNode.cells[5].innerHTML;
        let requirement = el.parentNode.parentNode.cells[6].innerHTML;
        let actual = el.parentNode.parentNode.cells[7].innerHTML;
        let po = el.parentNode.parentNode.cells[8].innerHTML;
        let os_contract = el.parentNode.parentNode.cells[9].innerHTML;
        let gr = el.parentNode.parentNode.cells[12].innerHTML;

        let ending_stock = parseFloat(stock.replace(",", "")) + parseFloat(requirement.replace(",", "")) + parseFloat(actual.replace(",", "")) + parseFloat(po.replace(",", "")) + parseFloat(os_contract.replace(",", ""));
        let standar_doi = (parseFloat(std_doi) / 100.0) * parseFloat(requirement.replace(",", ""));
        let total_pogr = parseFloat(po.replace(",", "")) + parseFloat(gr.replace(",", ""));
        let suggest_plan = Math.round((ending_stock + standar_doi) / 1000) * 1000;

        let head_id = el.parentNode.parentNode.cells[16].innerHTML;
        let plan_order = $(el).closest("tr").find("td:eq(15)").children().val();
        let created_date = el.parentNode.parentNode.cells[17].innerHTML;
        let year_month = el.parentNode.parentNode.cells[4].innerHTML;

        if (suggest_plan < 0) {
            suggest_plan = suggest_plan * -1;
        }

        if (!created_date) {
            Swal.fire('Date cannot empty', '', 'error');
            return;
        }

        $.ajax({
            url: "<?php echo site_url('mrp/mrp_data_detail_calculate/') ?>/" + created_date + "/" + plan_order + "/" + material_code + "/" + year_month + "/" + head_id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('.show_result').html(data.data);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });

        $(el).closest("tr").find("td:eq(15)").children().val(plan_order);

    }

    function purpose_data(el) {
        let material_code = el.parentNode.parentNode.cells[0].innerHTML;
        let month = el.parentNode.parentNode.cells[4].innerHTML;
        let head_id = el.parentNode.parentNode.cells[16].innerHTML;

        let plan_order = $(el).closest("tr").find("td:eq(15)").children().val();

        Swal.fire({
            title: 'Are you sure ?',
            text: "Data will be saved!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "<?php echo site_url('mrp/purpose_data/') ?>",
                    type: "POST",
                    data: {
                        material_code: material_code,
                        month: month,
                        plan_order: plan_order,
                        head_id: head_id
                    },
                    dataType: "JSON",
                    success: function(data) {
                        // console.log(data);
                        Swal.fire(
                            'Purpose!',
                            'Data successfully purpose',
                            'success'
                        );

                        $('#btn_date').val(created_date);
                        $('.show_result').html('');

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire(
                            'Tidak Berhasil!',
                            'Data tidak bisa di purpose',
                            'error'
                        )
                    }
                });

            }
        })

    }
</script>