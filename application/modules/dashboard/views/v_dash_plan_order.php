<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Dashboard</h2>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">                        
                            <i class="fa fa-fw ti-file"></i> Plan Order Data                   
                        </h3>
                        <span class="pull-right">
                            <i class="fa fa-fw ti-angle-up clickable"></i>                      
                            <i class="fa fa-fw ti-close removepanel clickable"></i>                
                        </span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        
                    <!-- <a style="float:right" class="btn btn-success" href="<?= site_url('sourcing/sourcing_add/') ?>"><i class="fa fa-plus"></i> Sourcing Add</a> -->
                        <div class="flash-message" id="flashdata" data-flashdata="<?= $this->session->flashdata('message')?>"></div>
                        <div class="flash-status" id="flashstatus" data-flashstatus="<?= $this->session->flashdata('status')?>"></div>
                        <br>
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" >
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Material Code</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Qty</th>
                                    <th>Vendor</th>
                                    <th>Create On</th>
                                    <th>Release On</th>
                                    <th>Action On</th>
                                    <th>Last Change</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                    <th>Trans No</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach($results as $row):
                                    ?>
                                    <tr>
                                        <td><?= $i?></td>
                                        <td><?= $row->material_code?></td>
                                        <td><?= $row->material_description?></td>
                                        <td><?= $row->status_val?></td>
                                        <td><?= $row->qty?></td>
                                        <td><?= $row->vendor_account?></td>
                                        <td><?= $row->created_on?></td>
                                        <td><?= $row->release_on?></td>
                                        <td><?= $row->action_on?></td>
                                        <td><?= $row->last_change?></td>
                                        <td><?= $row->remarks?></td>
                                        <td></td>
                                        <td><?= $row->trans_no?></td>
                                    </tr>

                                    <?php endforeach;?>
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
                "url": "<?php echo site_url('sourcing/sourcing_list')?>",
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

        // currency amount 
        $('#curramount').blur(function() {
				$('#curramount').html(null);
				$(this).formatCurrency({symbol:'', colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: 2 });
			})
			.keyup(function(e) {
				var e = window.event || e;
				var keyUnicode = e.charCode || e.keyCode;
				if (e !== undefined) {
					switch (keyUnicode) {
						case 16: break; // Shift
						case 17: break; // Ctrl
						case 18: break; // Alt
						case 27: this.value = ''; break; // Esc: clear entry
						case 35: break; // End
						case 36: break; // Home
						case 37: break; // cursor left
						case 38: break; // cursor up
						case 39: break; // cursor right
						case 40: break; // cursor down
						case 78: break; // N (Opera 9.63+ maps the "." from the number key section to the "N" key too!) (See: http://unixpapa.com/js/key.html search for ". Del")
						case 110: break; // . number block (Opera 9.63+ maps the "." from the number block to the "N" key (78) !!!)
						case 190: break; // .
						default: $(this).formatCurrency({ symbol:'', colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: -1, eventOnDecimalsEntered: true });
					}
				}
			})
			.bind('decimalsEntered', function(e, cents) {
				if (String(cents).length > 2) {
					var errorMsg = 'Please do not enter any cents (0.' + cents + ')';
					$('#curramount').html(errorMsg);
					// log('Event on decimals entered: ' + errorMsg);
				}
			});
    });

    function edit_sourcing(id){
        $('#form_edit_sourcing')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('contract/getContractEdit')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                
                $('[name="material_code"]').val(data.material_code);
                $('[name="material_description"]').val(data.material_description);
                $('[name="status_val"]').val(data.status_val);
                $('[name="qty"]').val(data.qty);
                $('[name="vendor_account"]').val(data.vendor_account);
                $('[name="remarks"]').val(data.remarks);
                $('[name="id"]').val(data.id);
				
                $('#modal_view_detail').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Detail'); 
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function approve_contract(id){
        $.ajax({
            url : "<?php echo site_url('contract/contract_approve/')?>/",
            type: "POST",
            data: {
                id :id
            },
            dataType: "JSON",
            success: function(data)
            {
                if(data.status) //if success close modal and reload ajax table
                {
                    reload_table();
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }

    function execute_contract(id){
        $.ajax({
            url : "<?php echo site_url('contract/contract_execute/')?>/",
            type: "POST",
            data: {
                id :id
            },
            dataType: "JSON",
            success: function(data)
            {
                if(data.status) //if success close modal and reload ajax table
                {
                    reload_table();
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }

    function save(){
        let url;
		
        url = "<?php echo site_url('contract/contract_edit')?>";
        form_data = $('#form_edit_sourcing').serialize();
        modal_type = $('#modal_view_detail').modal('hide');
        

        $.ajax({
            url : url,
            type: "POST",
            data: form_data,
            dataType: "JSON",
            success: function(data)
            {
                if(data.status) {
                    modal_type;
                    reload_table();
                } else {
                    alert(data.message);
                    return false;
                }

                // $('#btnSave').text('save'); //change button text
                // $('#btnSave').attr('disabled',false); //set button enable
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                reload_table();
            }
        });
    }

    function reload_table()
    {
        table.ajax.reload(null,false);
    }

    // Reject
    function delete_emp(emp_id)
    {  
        Swal.fire({
            title: 'Apa kamu yakin ?',
            text: "Data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!',
            cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {        
                    $.ajax({
                        url : "<?php echo site_url('employee/delete/')?>",
                        type: "POST",
                        data: {
                            emp_id :emp_id
                        },
                        dataType: "JSON",
                        success: function(data)
                        {
                            if(data.status) 
                            {
                                reload_table();
                                Swal.fire(
                                    'Terhapus!',
                                    'Data berhasil di hapus',
                                    'success'
                                )
                                
                                
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown)
                        {
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

<div class="modal fade" id="modal_view_detail" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Detail</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_edit_sourcing" class="form-horizontal">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-4">Material Code</label>
                            <div class="col-md-8">
                                <input name="material_code" placeholder="" class="form-control" type="text" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Material Description</label>
                            <div class="col-md-8">
                                <input name="material_description" placeholder="" class="form-control" type="text" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Status</label>
                            <div class="col-md-8">
                                <input name="status_val" placeholder="" class="form-control" type="text" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Qty</label>
                            <div class="col-md-8">
                                <input name="qty" placeholder="" class="form-control" type="text" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Vendor</label>
                            <div class="col-md-8">
                                <input name="vendor_account" placeholder="" class="form-control" type="text" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-4">Remarks</label>
                            <div class="col-md-8">
                                <input name="remarks" placeholder="" class="form-control" type="text" >
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->