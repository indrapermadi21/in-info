<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Add MRP</h2>
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
                            <i class="fa fa-fw ti-file"></i> Data MRP                   
                        </h3>
                        <span class="pull-right">
                            <i class="fa fa-fw ti-angle-up clickable"></i>                      
                            <i class="fa fa-fw ti-close removepanel clickable"></i>                
                        </span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    
                    <div class="flash-message" id="flashdata" data-flashdata="<?= $this->session->flashdata('message')?>"></div>
                    <div class="flash-status" id="flashstatus" data-flashstatus="<?= $this->session->flashdata('status')?>"></div>   

                    <?php echo form_open_multipart('mrp/import',array('name' => 'spreadsheet')); ?>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-2">File</label>
                            <div class="col-md-9">
                            <input class="form-control" type="file" size="40px" name="upload_file" />
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                    <input type="submit" class="btn btn-success" value="Import Data"/></td>
                    <?php echo form_close();?>
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
                "url": "<?php echo site_url('employee/ajax_list')?>",
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

    function add_salary()
    {
        document.location.href = "<?php echo site_url('salary/salary_add/')?>";
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

   