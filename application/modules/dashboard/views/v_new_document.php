<!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Laporan</h1>
            <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url('dashboard');?>">
                        <i class="fa fa-fw ti-file"></i> Laporan
                    </a>
                </li>
                <li> Penerimaan Berkas </li>
            </ol>
        </section>
        <!-- /.row -->
    <section class="content p-l-r-15">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        
                    </div>
                    <!-- /.panel-heading -->
                    <!-- <div class="row"> -->
                    <div class="panel-body">
                        
                        <div class="dataTable_wrapper">
                            <button style="float:right" class="btn btn-success" onclick="add_person()"><i class="fa fa-plus"></i> Tambah Dokumen</button>
                        </div>
                        </br></br></br></br>
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="dt_dash">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No SPM</th>
                                    <th>Tgl Penerimaan Document</th>
                                    <th>Dinas</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    <!-- </div> -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="background-overlay"></div>
    </section>
</aside>
<!-- /#page-wrapper -->
<script type="text/javascript">

    var save_method; //for save method string
    var table;

    $(document).ready(function() {

        //datatables
        table = $('#dt_dash').DataTable({

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('dashboard/ajax_list/?stat=1')?>",
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



    function add_person()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add Person'); // Set Title to Bootstrap modal title
    }

    function edit_mdoc(id)
    {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('dashboard/ajax_edit/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="document_number"]').val(data.document_number);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Person'); // Set title to Bootstrap modal title

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function accept_mdoc(id,value){
        //alert(id+'-----'+value);
        $.ajax({
            url : "<?php echo site_url('document/ajax_accept/')?>/",
            type: "POST",
            data: {
                document_number :id,
                status : value
            },
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    //   $('#modal_form').modal('hide');
                    reload_table();
                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax
    }

    function save()
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable
        var url;

        if(save_method == 'add') {
            url = "<?php echo site_url('document/ajax_add')?>";
        } else {
            url = "<?php echo site_url('document/ajax_update')?>";
        }

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                }

                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable


            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable

            }
        });
    }

    function delete_person(id)
    {
        if(confirm('Are you sure delete this data?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('document/ajax_delete')?>/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    //if success reload ajax table
                    $('#modal_form').modal('hide');
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });

        }
    }

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Nomor Dokumen</label>
                            <div class="col-md-9">
                                <input name="document_number" placeholder="Document Number" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Dinas</label>
                            <div class="col-md-9">
                                <select name="department" class="form-control">
                                    <option value="-">-- Pilih Dinas --</option>
                                    <?php foreach($department AS $dep){?>
                                        <option value="<?php echo $dep['dep_code']?>"><?php echo $dep['dep_name']?></option>
                                    <?php } // endforeach?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <!--div class="form-group">
                            <label class="control-label col-md-3">Tgl Dokumen</label>
                            <div class="col-md-9">
                                <input name="posting_date" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div-->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->