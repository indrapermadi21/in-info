<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Customer</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Customer &nbsp;</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="float-right">
                <a href="<?= base_url('customer/add_customer') ?>" class="btn btn-sm btn-info">
                    <i class="fas fa-plus">Tambah</i>
                </a>
            </div>
            <br><br>
            <div class="flash-message" id="flashdata" data-flashdata="<?= $this->session->flashdata('message') ?>"></div>
            <div class="flash-status" id="flashstatus" data-flashstatus="<?= $this->session->flashdata('status') ?>"></div>
            <table class="table table-striped table-bordered table-hover" id="dt_customer">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Customer</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
<script src="<?= base_url('assets/js/scriptmessage.js')?>" type="text/javascript"></script>
<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {

        //datatables
        table = $('#dt_customer').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('customer/customer_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-1], //last column
                "orderable": false, //set not orderable
            }, ],

        });

    });

    // Delete sourcing data
    function delete_customer(customer_code) {
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
                    url: "<?php echo site_url('customer/delete_customer/') ?>",
                    type: "POST",
                    data: {
                        customer_code: customer_code
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.status) {
                            reload_table();
                            Swal.fire('Deleted!','Data successful deleted','success'
                            )
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire('Error!','Data cannot be deleted','error')
                    }
                });

            }
        })

    }

    function reload_table() {
        table.ajax.reload(null, false);
    }
</script>