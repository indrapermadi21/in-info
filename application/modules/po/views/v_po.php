<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Purchase Order</h2>
            </div>
            <!-- <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url('dashboard');?>">
                        <i class="fa fa-fw ti-file"></i> Data
                    </a>
                </li>
                <li> <a href="<?php echo site_url('employee');?>">Karyawan</a></li>
            </ol> -->
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">                        
                            <i class="fa fa-fw ti-file"></i> Data PO                   
                        </h3>
                        <span class="pull-right">
                            <i class="fa fa-fw ti-angle-up clickable"></i>                      
                            <i class="fa fa-fw ti-close removepanel clickable"></i>                
                        </span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <br>
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="dt_employee">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Material Code</th>
                                    <th>Description</th>
                                    <th>Value</th>
                                    <th>Deliv. Date</th>
                                    <th>Qty</th>
                                    <th>Prch Doc.</th>
                                    <th>Vendor Account</th>
                                    <th>Remarks</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function() {

        //datatables
        table = $('#dt_employee').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('po/po_list')?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [ -1 ], //last column
                    "orderable": false, //set not orderable
                },
            ],

        });

    });

    </script>

   