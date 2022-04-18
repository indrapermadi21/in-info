<br>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pembayaran Invoice</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="flash-message" id="flashdata" data-flashdata="<?= $this->session->flashdata('message') ?>"></div>
        <div class="flash-status" id="flashstatus" data-flashstatus="<?= $this->session->flashdata('status') ?>"></div>
        <div class="card-body">
            <form id="form_inv_payment" action="<?= base_url('invoice/payment') ?>" method="POST" class="form-horizontal">
                <div class="form-group row">
                    <label for="payment_number" class="col-sm-2 col-form-label">Nomor Pembayaran</label>
                    <div class="form-validation col-sm-3">
                        <input type="text" class="form-control" id="payment_number" name="payment_number" value="<?= $payment_number ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="invoice_number" class="col-sm-2 col-form-label">Nomor Invoice</label>
                    <div class="form-validation col-sm-3">
                        <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="<?= !$result ? '' : $result['invoice_number'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="payment_date" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="form-validation col-sm-2">
                        <input type="date" class="form-control" id="payment_date" name="payment_date">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="customer" class="col-sm-2 col-form-label">Customer</label>
                    <div class="form-validation col-sm-3">
                        <input type="text" class="form-control" id="customer" name="customer" value="<?= !$result ? '' : $result['customer'] ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="total_amount" class="col-sm-2 col-form-label">Total Invoice</label>
                    <div class="form-validation col-sm-2">
                        <input type="text" class="form-control" id="total_amount" name="total_amount" value="<?= !$result ? '' : number_format($result['total_amount'], 0) ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="total_payment" class="col-sm-2 col-form-label">Jumlah Bayar</label>
                    <div class="form-validation col-sm-2">
                        <input type="text" class="form-control" id="total_payment" name="total_payment" value="" placeholder="">
                    </div>
                </div>
                <div class="row">
                    <hr>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-3">
                        <button class="btn btn-primary" type="submit" id="btn_submit" name="btn_submit" value="Save">Save</button>
                    </div>
                </div>
                <div class="row">
                    <hr>
                </div>
            </form>
            <div class="row">
                <hr>
            </div>
            <div class="form-group row">
                <label for="history_payment" class="col-sm-2 col-form-label">Riwayat Pembayaran</label>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered table-hover" id="materialItemTable">
                    <thead>
                        <tr>
                            <th>No Pembayaran</th>
                            <th>Tanggal Bayar</th>
                            <th>Jumlah Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result_payment as $row) : ?>
                            <tr>
                                <td><?= $row['payment_number'] ?></td>
                                <td><?= $row['payment_date'] ?></td>
                                <td><?= number_format($row['total_payment'], 0) ?></td>
                                <td><a href="#" class="btn btn-info"><i class="fa fa-print"></i>Print</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div><!-- /.col -->
    </div>
    <!-- /.card-body -->
    </div>
</section>
<script src="<?= base_url('assets/js/scriptmessage.js') ?>" type="text/javascript"></script>
<script>
    $(function() {
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        $('#form_inv_payment').validate({
            rules: {
                payment_date: "required",
                total_payment: "required",
            },
            messages: {
                payment_date: "Tanggal tidak boleh kosong",
                total_payment: "Jumlah pembayaran tidak boleh kosong",
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

        $('#form_inv_payment').submit(function() {

        });


    });

    $('#notifications').slideDown('slow').delay(3500).slideUp('slow');
</script>