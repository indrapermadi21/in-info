<!-- global css -->

<!-- <link type="text/css" rel="stylesheet" href="<?php echo base_url($themes_url); ?>css/app.css" /> -->

<!-- end of global css -->

<!--page level css -->

<!-- <link rel="stylesheet" href="<?php echo base_url($themes_url); ?>vendors/swiper/css/swiper.min.css">

<link href="<?php echo base_url($themes_url); ?>vendors/nvd3/css/nv.d3.min.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="<?php echo base_url($themes_url); ?>vendors/lcswitch/css/lc_switch.css">

<link rel="stylesheet" type="text/css" href="<?php echo base_url($themes_url); ?>css/custom.css">

<link rel="stylesheet" href="<?php echo base_url($themes_url); ?>css/custom_css/skins/skin-default.css" type="text/css" id="skin" />

<link href="<?php echo base_url($themes_url); ?>css/custom_css/dashboard1.css" rel="stylesheet" type="text/css" />

<link href="<?php echo base_url($themes_url); ?>css/custom_css/dashboard1_timeline.css" rel="stylesheet" /> -->

<!-- Font Awesome -->
<!-- <link rel="stylesheet" href="<?php echo base_url($themes_url); ?>css/fontawesome-free/css/all.min.css"> -->
<!-- Tempusdominus Bootstrap 4 -->
<!-- <link rel="stylesheet" href="<?php echo base_url($themes_url); ?>css/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"> -->
<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
<!-- Content Header (Page header) -->
<script src="<?php echo $themes_url; ?>vendors/chartjs-bc/chart.js"></script>
<section class="content-header">
    <h1>Dashboard</h1>
</section>
<!-- /.row -->
<section class="content p-l-r-15">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5></h5>
                    </div>
                    <!-- /.panel-heading -->
                    <!-- <div class="row"> -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4 col-sm-6">
                                <div class="card-box bg-info">
                                    <div class="inner">
                                        <h3> <?= $result->plan_order ? $result->plan_order : 0; ?> </h3>
                                        <p> Plan Order </p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </div>
                                    <a href="<?= base_url('dashboard/plan_order')?>" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-6">
                                <div class="card-box bg-warning">
                                    <div class="inner">
                                        <h3> <?= $result->osc ? $result->osc : 0; ?> </h3>
                                        <p> OS Contract </p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-file" aria-hidden="true"></i>
                                    </div>
                                    <a href="<?= base_url('dashboard/os_contract')?>" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="card-box bg-success">
                                    <div class="inner">
                                        <h3> <?= $result->poun ? $result->poun : 0; ?> </h3>
                                        <p> PO Unrelease </p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                    </div>
                                    <a href="<?= base_url('dashboard/po_unrelease')?>" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-sm-4">
                                <div class="card-box bg-danger">
                                    <div class="inner">
                                        <?php

                                        $total_pogr = $result_pogr->po + $result_pogr->gr;
                                        $per_po = $result_pogr->po ? ($result_pogr->po / $total_pogr) * 100 : 0;
                                        $per_gr = $result_pogr->gr ? ($result_pogr->gr / $total_pogr) * 100 : 0;
                                        ?>
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <p>Purchase Order</p>
                                                </td>
                                                <td style="text-align: right;">
                                                    <p><?= number_format($per_po, 3) ?>%</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>Goods Receive</p>
                                                </td>
                                                <td style="text-align: right;">
                                                    <p><?= number_format($per_gr, 3) ?>%</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>
                                                        <p>Total</p>
                                                    </strong></td>
                                                <td style="text-align: right;">
                                                    <p><?= number_format($per_po + $per_gr, 0) ?>%</p>
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                    <!-- <div class="icon">
                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                    </div> -->
                                    <!-- <a href="#" class="card-box-footer">View More <i class="fa fa-arrow-circle-right"></i></a> -->
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                <canvas id="myChart" width="100" height="100"></canvas>
                            </div>
                            <div class="col-lg-4 col-sm-4">
                                
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="background-overlay"></div>
</section>
</aside>
<!-- <script src="<?php echo base_url($themes_url); ?>js/app.js" type="text/javascript"></script> -->

<!-- end of global js -->



<!-- begining of page level js -->

<!--Sparkline Chart-->

<!-- <script type="text/javascript" src="<?php echo base_url($themes_url); ?>js/custom_js/sparkline/jquery.flot.spline.js"></script> -->

<!-- flip --->

<script type="text/javascript" src="<?php echo base_url($themes_url); ?>vendors/flip/js/jquery.flip.min.js"></script>

<script type="text/javascript" src="<?php echo base_url($themes_url); ?>vendors/lcswitch/js/lc_switch.min.js"></script>

<!--flot chart-->

<!-- <script type="text/javascript" src="<?php echo base_url($themes_url); ?>vendors/flotchart/js/jquery.flot.js"></script>

<script type="text/javascript" src="<?php echo base_url($themes_url); ?>vendors/flotchart/js/jquery.flot.resize.js"></script>

<script type="text/javascript" src="<?php echo base_url($themes_url); ?>vendors/flotchart/js/jquery.flot.stack.js"></script>

<script type="text/javascript" src="<?php echo base_url($themes_url); ?>vendors/flotspline/js/jquery.flot.spline.min.js"></script>

<script type="text/javascript" src="<?php echo base_url($themes_url); ?>vendors/flot.tooltip/js/jquery.flot.tooltip.js"></script>

<!--swiper-->

<!-- <script type="text/javascript" src="<?php echo base_url($themes_url); ?>vendors/swiper/js/swiper.min.js"></script> -->

<!--chartjs-->

<!-- <script src="<?php echo base_url($themes_url); ?>vendors/chartjs/js/Chart.js"></script> -->

<!--nvd3 chart-->

<!-- <script type="text/javascript" src="<?php echo base_url($themes_url); ?>js/nvd3/d3.v3.min.js"></script>

<script type="text/javascript" src="<?php echo base_url($themes_url); ?>vendors/nvd3/js/nv.d3.min.js"></script>

<script type="text/javascript" src="<?php echo base_url($themes_url); ?>vendors/moment/js/moment.min.js"></script>

<script type="text/javascript" src="<?php echo base_url($themes_url); ?>vendors/advanced_newsTicker/js/newsTicker.js"></script>

<script type="text/javascript" src="<?php echo base_url($themes_url); ?>js/custom_js/dashboard_verify.js"></script>  -->
<!-- /#page-wrapper -->
<script type="text/javascript">
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Purchase Order", "Goods Receive"],
            datasets: [{
                label: '# of Votes',
                data: [<?= $per_po ?>, <?= $per_gr ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'PO Vs GR'
                }
            }
        },
    });

    $(document).ready(function() {

        //datepicker
        $('.datepicker').datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
        });

    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax
    }
</script>