<br>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Material</h3>

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
            <form id="form_material" action="<?= base_url('material/saved') ?>" method="POST" class="form-horizontal">
                <input type="hidden" name="type" id="type" value="<?= $type ?>">
                <div class="form-group row">
                    <label for="material_code" class="col-sm-2 col-form-label">Kode Material</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="material_code" name="material_code" value="<?= !$result ? $material_code : $result['material_code'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="material_description" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="form-validation col-sm-6">
                        <input type="text" class="form-control" id="material_description" name="material_description" value="<?= !$result ? '' : $result['material_description'] ?>" placeholder="Material Description">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="uom_code" class="col-sm-2 col-form-label">Satuan</label>
                    <div class="form-validation col-sm-4">
                        <input type="text" class="form-control" id="uom_code" name="uom_code" value="<?= !$result ? '' : $result['uom_code'] ?>" placeholder="Unit of Meassurement">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="supplier_code" class="col-sm-2 col-form-label">Supplier</label>
                    <div class="form-validation col-sm-5">
                        <select class="form-control select2" style="width: 100%;" id="supplier_code" name="supplier_code">
                            <option value="">-- Pilih Supplier --</option>
                            <?php
                            foreach ($supplier_list as $row) :
                            ?>
                                <option value="<?= $row['supplier_code'] ?>"><?= $row['supplier_code'] . ' - ' . $row['supplier_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <hr>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-3">
                        <button class="btn btn-primary" type="submit" id="btn_submit" name="btn_submit" value="Save">Simpan</button>
                    </div>
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

        $('#form_material').validate({
            rules: {
                material_description: "required",
                uom_code: "required",
                supplier_code : "required"
            },
            messages: {
                material_description: "Nama material tidak boleh kosong",
                uom_code: "Satuan barang tidak boleh kosong",
                supplier_code : "Supplier tidak boleh kosong"
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
    });
    $('#notifications').slideDown('slow').delay(3500).slideUp('slow');
</script>