<br>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Supplier</h3>

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
            <form id="form_supplier" action="<?= base_url('supplier/saved') ?>" method="POST" class="form-horizontal">
                <input type="hidden" name="type" id="type" value="<?= $type ?>">
                <div class="form-group row">
                    <label for="supplier_code" class="col-sm-2 col-form-label">Kode Supplier</label>
                    <div class="form-validation col-sm-6">
                        <input type="text" class="form-control" id="supplier_code" name="supplier_code" value="<?= !$result ? $supplier_code : $result['supplier_code'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="supplier_name" class="col-sm-2 col-form-label">Nama Supplier</label>
                    <div class="form-validation col-sm-6">
                        <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="<?= !$result ? '' : $result['supplier_name'] ?>" placeholder="Nama Supplier">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="uom_code" class="col-sm-2 col-form-label">Alamat</label>
                    <div class="form-validation col-sm-10">
                        <input type="text" class="form-control" id="address" name="address" value="<?= !$result ? '' : $result['address'] ?>" placeholder="Alamat">
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

        $('#form_supplier').validate({
            rules: {
                // supplier_code: {
                //     required: true,
                //     minlength: 4,
                //     remote: {
                //         url: "<?= base_url('supplier/checkCodeExist') ?>",
                //         type: "post",
                //         data: {
                //             supplier_code: function() {
                //                 return $("#supplier_code").val();
                //             }
                //         }
                //     }
                // },
                supplier_name: "required",
                address: "required"
            },
            messages: {
                // supplier_code: {
                //     required: "Supplier Code tidak boleh kosong",
                //     remote: "Supplier kode ini sudah ada !."
                // },
                supplier_name: "Nama supplier tidak boleh kosong",
                address: "Alamat tidak boleh kosong"
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