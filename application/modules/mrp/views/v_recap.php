<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">MRP</h2>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">                        
                            <i class="fa fa-fw ti-file"></i> Data MRP Recap                 
                        </h3>
                        <span class="pull-right">
                            <i class="fa fa-fw ti-angle-up clickable"></i>                      
                            <i class="fa fa-fw ti-close removepanel clickable"></i>                
                        </span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        
                    <!-- <a style="float:right" class="btn btn-success" href="<?= site_url('mrp/mrp_add/') ?>"><i class="fa fa-plus"></i> Upload Data</a> -->
                        <div class="flash-message" id="flashdata" data-flashdata="<?= $this->session->flashdata('message')?>"></div>
                        <div class="flash-status" id="flashstatus" data-flashstatus="<?= $this->session->flashdata('status')?>"></div>
                    
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-1">Date</label>
                                <div class="col-md-2">
                                <input class="form-control" type="date" size="40px" id="created_date" name="created_date" />
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="btn_date" class="btn btn-success" >Show</button>
                                    <button type="button" id="btn_download" class="btn btn-info" >Download</button>
                                </div>
                                <div class="col-md-2" style="float:right">
                                    <button type="button" id="btn_delete" class="btn btn-danger" >Delete</button>
                                </div>
                            </div>

                        </div>
                        <br><br>
                        <div class="show_result">
                            
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

        $('#btn_date').click(function(){
            let created_date = $('#created_date').val();
            if(!created_date){
                Swal.fire('Date cannot empty', '', 'error');
                return;
            }

            $.ajax({
            url : "<?php echo site_url('mrp/mrp_data_detail/')?>/"+ created_date,
            type: "GET",
            dataType: "JSON",
            success: function(data)
                {
                    $('.show_result').html(data.data);

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        });

        $('#btn_download').click(function(){
            let created_date = $('#created_date').val();
            if(!created_date){
                Swal.fire('Date cannot empty', '', 'error');
                return;
            }
            window.location.href = "<?php echo base_url('mrp/download_excel/')?>"+created_date;
        });

        $('#btn_delete').click(function(){
            let created_date = $('#created_date').val();
            if(!created_date){
                Swal.fire('Date cannot empty', '', 'error');
                return;
            }

            $.ajax({
            url : "<?php echo site_url('mrp/mrp_data_delete/')?>",
            type: "POST",
            data: {
                created_date :created_date
            },
            dataType: "JSON",
            success: function(data)
                {
                    Swal.fire(data.message, '', data.icon)  
                    $('.show_result').html(data.data); 
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    // alert('Error get data from ajax');
                    Swal.fire('Error get data from ajax', '', 'error')
                    
                }
            });
            
        });

    });

    </script>

   