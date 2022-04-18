<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">Sourcing Add</h2>
            </div>
            <!-- <ol class="breadcrumb">
                <li>
                    <a href="<?php echo site_url('dashboard'); ?>">
                        <i class="fa fa-fw ti-file"></i> Data
                    </a>
                </li>
                <li> <a href="<?php echo site_url('employee'); ?>">Karyawan</a></li>
            </ol> -->
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <?php
        if ($this->session->flashdata('message_error')) {
        ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?= $this->session->flashdata('message_error'); ?>
            </div>
        <?php
        }
        ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="fa fa-fw ti-file"></i> Sourcing
                        </h3>
                        <span class="pull-right">
                            <i class="fa fa-fw ti-angle-up clickable"></i>
                            <i class="fa fa-fw ti-close removepanel clickable"></i>
                        </span>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <?php echo form_open_multipart('sourcing/saved', array('name' => 'spreadsheet')); ?>
                        <div class="form-body">
                            <input type="hidden" name="type" value="<?= $type ?>" />
                            <input type="hidden" name="id" value="<?= $id ?>" />
                            <input class="form-control" type="hidden" size="40px" name="image" />
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">File Image</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="file" size="40px" name="image" />
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Material Code</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" size="50px" name="material_code" value="<?= !$result ? '' : $result->material_code ?>" />
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Description</label>
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" size="100px" name="material_description" value="<?= !$result ? '' : $result->material_description ?>" />
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Material Group</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" size="50px" name="material_group" value="<?= !$result ? '' : $result->material_group ?>" />
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Vendor</label>
                                    <div class="col-md-4">
                                        <input class="form-control" type="text" size="50px" name="vendor_account" value="<?= !$result ? '' : $result->vendor_account ?>" />
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Ldt</label>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" size="50px" name="ldt" value="<?= !$result ? '' : $result->ldt ?>" />
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Std Doi</label>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" size="50px" name="std_doi" value="<?= !$result ? '' : $result->std_doi ?>" />
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Moq</label>
                                    <div class="col-md-2">
                                        <input class="form-control" type="text" size="50px" name="moq" value="<?= !$result ? '' : $result->moq ?>" />
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-success" value="Submit" /></td>
                        <?php echo form_close(); ?>
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

</script>