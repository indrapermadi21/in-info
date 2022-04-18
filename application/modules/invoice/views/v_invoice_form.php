<br>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Invoice</h3>

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
            <form id="form_invoice" action="<?= base_url('invoice/saved') ?>" method="POST" class="form-horizontal">
                <input type="hidden" name="type" id="type" value="<?= $type ?>">
                <div class="form-group row">
                    <label for="invoice_number" class="col-sm-2 col-form-label">Nomor Invoice</label>
                    <div class="form-validation col-sm-5">
                        <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="<?= !$result ? $invoice_number : $result['invoice_number'] ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="reference_number" class="col-sm-2 col-form-label">Referensi Nomor</label>
                    <div class="form-validation col-sm-2">
                        <input type="text" class="form-control" id="reference_number" name="reference_number" value="<?= !$result ? '' : $result['reference_number'] ?>">
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-info" id="btn_reference">Check Ref</button>

                    </div>
                </div>
                <div class="form-group row">
                    <label for="posting_date" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="form-validation col-sm-2">
                        <input type="date" class="form-control" id="posting_date" name="posting_date" value="<?= !$result ? '' : $result['posting_date'] ?>" placeholder="Posting Date">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="due_date" class="col-sm-2 col-form-label">Batas Tgl.Bayar</label>
                    <div class="form-validation col-sm-2">
                        <input type="date" class="form-control" id="due_date" name="due_date" value="<?= !$result ? '' : $result['due_date'] ?>" placeholder="Posting Date">
                    </div>
                </div>
                <input type="hidden" class="form-control" id="ref_date" name="ref_date" value="<?= !$result ? '' : $result['posting_date'] ?>" placeholder="Posting Date">
                <div class="form-group row">
                    <label for="customer" class="col-sm-2 col-form-label">Customer</label>
                    <div class="form-validation col-sm-5">
                        <input type="text" class="form-control" id="customer" name="customer" value="<?= !$result ? '' : $result['customer'] ?>" placeholder="Customer">
                    </div>
                </div>
                <div class="row">
                    <hr>
                </div>
                <div class="row">
                    <hr>
                </div>
                <div class="row">
                    <table class="table table-striped table-bordered table-hover" id="materialItemTable">

                        <thead>
                            <tr>
                                <th>Kode Material</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Total</th>
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
                                $total_amount = 0;
                                foreach ($result_item as $row) :
                                    $total = $row['qty'] * $row['price'];
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
                                        <td style="text-align: center;">
                                            <?= $row['qty'] ?>
                                            <input type="hidden" class="form-control" id="qty_item" name="qty_item[]" value="<?= $row['qty'] ?>" />
                                        </td>
                                        <td style="text-align: right;">
                                            <?= number_format($row['price'],0) ?>
                                            <input type="hidden" class="form-control" id="price_item" name="price_item[]" value="<?= $row['price'] ?>" />
                                        </td>
                                        <td style="text-align: right;">
                                            <?= number_format($total,0) ?>
                                            <input type="hidden" class="form-control" id="total" name="total[]" value="<?= $total ?>" />
                                        </td>
                                    </tr>
                                <?php
                                    $total_amount += $total;
                                endforeach; ?>

                                <tr>
                                    <td colspan="4" style="text-align: right;"><strong>Subtotal</strong></td>
                                    <td style="text-align: right;"><strong><?= number_format($total_amount, 0) ?></strong></td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
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

        $('#form_invoice').validate({
            rules: {
                posting_date: "required",
                reference_number: "required",
                customer: "required",
            },
            messages: {
                posting_date: "Tanggal tidak boleh kosong",
                reference_number: "No. Referensi tidak boleh kosong",
                customer: "Customer tidak boleh kosong",
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

        $('#form_invoice').submit(function() {

            //write your validation code here. and make sure about jquery library is loaded.

        });

        $('#btn_reference').click(function(e) {
            e.preventDefault();
            let reference_number = $('#reference_number').val();
            
            $.ajax({
                url: "<?php echo site_url('invoice/getSalesData/') ?>",
                type: "POST",
                data: {
                    reference_number: reference_number
                },
                dataType: "JSON",
                success: function(r) {
                    let customer = r.data.head.customer;
                    let ref_date = r.data.head.posting_date;
            
                    // alert(data);
                    $('#customer').val(customer);
                    $('#ref_date').val(ref_date);
            
                    var sub_total = 0;
                    // console.log(r.data.item.length);
                    $(".customMaterial").empty();
                    $.each(r.data.item, function(index, value) {
                        // console.log(index + ' : ' + value.id);
                        // $("input[name='material_code_item']").val(value.material_code);
                        // $("input[name='qty_item']").val(value.qty);
                        // $("input[name='uom_item']").val(value.uom_code);
                        // $("input[name='price_item']").val(value.price);


                        $('.customMaterial').append(
                            '<tr><td>' + value.material_code + ' - ' + value.material_description +
                            '</td><td>' + value.uom_code +
                            '</td><td>' + value.qty +
                            '</td><td align="right">' + value.price +
                            '</td><td align="right">' + value.total +
                            '</td></tr>'
                        );

                        sub_total = parseFloat(sub_total) + parseFloat(value.total);

                    });

                    $('.customMaterial').append(
                            '<tr><td></td><td></td><td></td><td><strong>Sub Total</strong>' + 
                            '</td><td align="right"><strong>' + sub_total +
                            '</strong></td></tr>'
                        );


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire('Error!', 'Data tidak bisa di hapus', 'error')
                }
            });
        });

    });

    $('#notifications').slideDown('slow').delay(3500).slideUp('slow');
</script>