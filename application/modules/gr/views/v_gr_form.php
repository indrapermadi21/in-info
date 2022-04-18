<br>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Goods Receive</h3>

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
            <form id="form_gr" action="<?= base_url('gr/saved') ?>" method="POST" class="form-horizontal">
                <input type="hidden" name="type" id="type" value="<?= $type ?>">
                <div class="form-group row">
                    <label for="gr_number" class="col-sm-2 col-form-label">Nomor Pembelian</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="gr_number" name="gr_number" value="<?= !$result ? $gr_number : $result['gr_number'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="posting_date" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="form-validation col-sm-2">
                        <input type="date" class="form-control" id="posting_date" name="posting_date" value="<?= !$result ? '' : $result['posting_date'] ?>" placeholder="Posting Date">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="vehicle_number" class="col-sm-2 col-form-label">No. Kendaraan</label>
                    <div class="form-validation col-sm-3">
                        <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" value="<?= !$result ? '' : $result['vehicle_number'] ?>" placeholder="Vehicle Number">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="supplier" class="col-sm-2 col-form-label">Supplier</label>
                    <div class="col-sm-5">
                        <select class="form-control select2" style="width: 100%;" id="supplier" name="supplier">
                            <option value="-">-- Pilih Supplier --</option>
                            <?php
                            foreach ($supplier_list as $row) :
                            ?>
                                <option value="<?= $row['supplier_code'] ?>"><?= $row['supplier_code'] . ' - ' . $row['supplier_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="due_date" class="col-sm-2 col-form-label">Tgl. Kontra</label>
                    <div class="form-validation col-sm-2">
                        <input type="date" class="form-control" id="due_date" name="due_date" value="<?= !$result ? '' : $result['due_date'] ?>" placeholder="Posting Date">
                    </div>
                </div>
                <div class="row">
                    <hr>
                </div>
                <div class="form-group row">
                    <label for="material_code" class="col-sm-2 col-form-label">Kode Material</label>
                    <div class="col-sm-5">
                        <select class="form-control select2" style="width: 100%;" id="material_code" name="material_code">
                            <option value="-">-- Pilih Material --</option>
                            <?php
                            foreach ($material_list as $row) :
                            ?>
                                <option value="<?= $row['material_code'] ?>"><?= $row['material_code'] . ' - ' . $row['material_description'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="qty" class="col-sm-2 col-form-label">Jumlah</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="qty" name="qty" value="" placeholder="Qty">
                    </div>
                    <div class="col-sm-3">
                        <a href="javascript:void(0);" class="btn btn-info addGrItem"><i class="fa fa-plus">&nbsp;&nbsp;Add</i></a>
                    </div>
                </div>
                <div class="row">
                    <hr>
                </div>
                <div class="row">
                    <table class="table table-striped table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <?php

                        if (!$result_item) {
                        ?>
                            <tbody class="customMaterial"></tbody>
                        <?php
                        } else {
                        ?>
                            <tbody class="customMaterial">
                                <?php
                                foreach ($result_item as $row) :
                                ?>
                                    <tr valign="top">
                                        <td>
                                            <?= $row['material_code'] . ' - ' . $row['material_description'] ?>
                                            <input type="hidden" class="form-control" id="material_code_item" name="material_code_item[]" value="<?= $row['material_code'] ?>" />
                                        </td>
                                        <td>
                                            <?= $row['uom_code'] ?>
                                            <input type="hidden" class="form-control" id="uom_code_item" name="uom_code_item[]" value="<?= $row['uom_code'] ?>" />
                                        </td>
                                        <td>
                                            <?= $row['qty'] ?>
                                            <input type="hidden" class="form-control" id="qty_item" name="qty_item[]" value="<?= $row['qty'] ?>" />
                                        </td>
                                        <td>
                                            <div class="form-validation col-sm-5">
                                                <input type="text" class="form-control" id="price_item" name="price_item[]" value="<?= $row['price'] ?>" placeholder="Price" />
                                            </div>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-danger removeGrItem">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
                <div class="row">
                    <hr>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-3">
                        <button class="btn btn-primary" type="submit" id="btn_submit" name="btn_submit" value="Save">Simpan</button>
                    </div>
                </div>
                <div class="row">
                    <hr>
                </div>





            </form>
        </div><!-- /.col -->
    </div>
    <!-- /.card-body -->
    </div>
</section>

<script>
    $(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        let i = 0;
        $('.addGrItem').click(function() {
            i++;

            let material_code = $('#material_code').val();
            let qty = $('#qty').val();

            if (material_code == '-') {
                Swal.fire('Error!', 'Pilih material', 'error');
                return;
            }

            if (!qty) {
                Swal.fire('Error!', 'Jumlah tidak boleh kosong', 'error');
                return;
            }

            $.ajax({
                url: "<?php echo site_url('gr/getMaterialRow') ?>",
                type: "POST",
                data: {
                    material_code: material_code
                },
                dataType: "JSON",
                success: function(response) {

                    let uom_code = response.data.uom_code;
                    let material_description = response.data.material_description;
                    $('.customMaterial').append('<tr valign="top"><td>' + material_code + ' - ' + material_description + '<input type="hidden" class="form-control" value="' + material_code + '" id="material_code_item" name="material_code_item[]" /></td><td>' + uom_code + '<input type="hidden" class="form-control" value="' + uom_code + '" id="uom_code_item" name="uom_code_item[]" /></td><td>' + qty + '<input type="hidden" class="form-control" id="qty_item" name="qty_item[]" value="' + qty + '" /></td><td><div class="col-sm-5"><input type="text" class="form-control" id="price_item_' + i + '" name="price_item[]" value="" placeholder="Price" /></div></td><td><a href="javascript:void(0);" class="btn btn-danger removeGrItem">Remove</a></td></tr>');
                    $('#material_code').val('-').trigger('change');
                    $('#qty').val('');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire('Error!', 'Data tidak bisa dihapus', 'error')
                }
            });


        });

        $(".customMaterial").on('click', '.removeGrItem', function() {
            $(this).parent().parent().remove();
        });

        $('#form_gr').validate({
            rules: {
                posting_date: "required",
                vehicle_number: "required",
                supplier: "required",
                due_date: "required",
                price_item: {
                    required: function(elem) {
                        return $(elem).siblings('select').val() == '0';
                    }
                }
            },
            messages: {
                posting_date: "Tanggal tidak boleh kosong",
                vehicle_number: "No. Kendaraan tidak boleh kosong",
                supplier: "Supplier tidak boleh kosong",
                due_date: "Tanggal kontra bon tidak boleh kosong",
                price_item: "Harga tidak boleh kosong"
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-validation ').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $('#form_gr').submit(function() {
            if (!$('#material_code_item').val()) {
                Swal.fire('Error!', 'Minimal isi 1 data item', 'error');
                return false;
            }

            $('input[name="price_item"]').each(function() {
                $(this).rules("add", {
                    required: true
                })
            });
            //write your validation code here. and make sure about jquery library is loaded.

        });

    });
    $('#notifications').slideDown('slow').delay(3500).slideUp('slow');
</script>