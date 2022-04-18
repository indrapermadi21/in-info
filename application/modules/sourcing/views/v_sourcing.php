<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Sourcing</h2>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-fw ti-file"></i> Sourcing Data
                        </h3>
                        <span class="pull-right">
                            <i class="fa fa-fw ti-angle-up clickable"></i>
                            <i class="fa fa-fw ti-close removepanel clickable"></i>
                        </span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <a style="float:right" class="btn btn-success" href="<?= site_url('sourcing/sourcing_add/') ?>"><i class="fa fa-plus"></i> Sourcing Add</a>
                        <div class="flash-message" id="flashdata" data-flashdata="<?= $this->session->flashdata('message') ?>"></div>
                        <div class="flash-status" id="flashstatus" data-flashstatus="<?= $this->session->flashdata('status') ?>"></div>

                        <br><br><br>
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="dt_employee">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Image</th>
                                        <th>Material Code</th>
                                        <th>Description</th>
                                        <th>Material Group</th>
                                        <th>Vendor</th>
                                        <th>LDT</th>
                                        <th>Std Doi</th>
                                        <th>MOQ</th>
                                        <th>Action</th>
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
<script src="<?php echo $themes_url; ?>js/scriptmessage.js" type="text/javascript"></script>
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
                "url": "<?php echo site_url('sourcing/sourcing_list') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-1], //last column
                "orderable": false, //set not orderable
            }, ],

        });

    });

    function reload_table() {
        table.ajax.reload(null, false);
    }

    // Delete sourcing data
    function delete_sourcing(id) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "The data cannot be restore!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo site_url('sourcing/sourcing_delete/') ?>",
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            reload_table();
                            Swal.fire(
                                'Terhapus!',
                                'Data berhasil di hapus',
                                'success'
                            )


                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire(
                            'Tidak Berhasil!',
                            'Data tidak bisa dihapus',
                            'error'
                        )
                    }
                });

            }
        })

    }
</script>