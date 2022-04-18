<br>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Customer</h3>

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
            <form id="form_customer" action="<?= base_url('customer/saved') ?>" method="POST" class="form-horizontal">
                <input type="hidden" name="type" id="type" value="<?= $type ?>">
                <div class="form-group row">
                    <label for="customer_code" class="col-sm-2 col-form-label">Kode Pelanggan</label>
                    <div class="form-validation col-sm-6">
                        <input type="text" class="form-control" id="customer_code" name="customer_code" value="<?= !$result ? $customer_code : $result['customer_code'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="customer_name" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                    <div class="form-validation col-sm-6">
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?= !$result ? '' : $result['customer_name'] ?>" placeholder="Nama Customer">
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

        $('#form_customer').validate({
            rules: {
                // customer_code: {
                //     required: true,
                //     minlength: 4,
                //     remote: {
                //         url: "<?= base_url('customer/checkCodeExist') ?>",
                //         type: "post",
                //         data: {
                //             customer_code: function() {
                //                 return $("#customer_code").val();
                //             }
                //         }
                //     }
                // },
                customer_name: "required",
                address: "required"
            },
            messages: {
                // customer_code: {
                //     required: "Customer Code tidak boleh kosong",
                //     remote: "Customer kode ini sudah ada !."
                // },
                customer_name: "Nama customer tidak boleh kosong",
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