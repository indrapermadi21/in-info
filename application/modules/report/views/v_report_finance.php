<br>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Laporan</h3>

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

            <div class="form-group row">
                <label for="finance_type" class="col-sm-2 col-form-label">Tipe Laporan</label>
                <div class="col-sm-5">
                    <select class="form-control select2" style="width: 100%;" id="finance_type" name="finance_type">
                        <option value="-">-- Pilih Tipe --</option>
                        <option value="gr_detail">Detail Pembelian</option>
                        <option value="sales_detail">Detail Penjualan</option>
                        <!-- <option value="day">Harian</option> -->
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="stock_date" class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="from_date">
                </div>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="to_date">
                </div>
            </div>
            <div class="row">
                <hr>
            </div>
            <div class="form-group row">
                <div class="d-grid gap-2 d-md-block ">
                    <button class="btn btn-primary" type="button" id="btn_preview" name="btn_preview" value="Preview">Lihat</button>
                    <button class="btn btn-success" type="button" id="btn_preview_pdf" name="btn_preview_pdf" value="Preview">Print PDF</button>
                </div>
            </div>

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

        $("#btn_preview").click(function() {
            let finance_type = $('#finance_type').val();
            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();

            if (finance_type=='-') {
                Swal.fire('Error!','Pilih Tipe Laporan','error');
                return;
            }

            if (!from_date) {
                Swal.fire('Error!','Pilih Tanggal','error');
                return;
            }

            if (!to_date) {
                Swal.fire('Error!','Pilih Tanggal','error');
                return;
            }

            //this will redirect us in new tab
            window.open('<?= base_url('report/finance_preview/') ?>' + from_date + '/' + to_date + '/' + finance_type , '_blank');
        });

        $("#btn_preview_pdf").click(function() {
            let finance_type = $('#finance_type').val();
            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();

            if (finance_type=='-') {
                Swal.fire('Error!','Pilih Tipe Laporan','error');
                return;
            }

            if (!from_date) {
                Swal.fire('Error!','Pilih Tanggal','error');
                return;
            }

            if (!to_date) {
                Swal.fire('Error!','Pilih Tanggal','error');
                return;
            }

            //this will redirect us in new tab
            window.open('<?= base_url('report/finance_preview_pdf/') ?>' + from_date + '/' + to_date + '/' + finance_type , '_blank');
        });
    });
    $('#notifications').slideDown('slow').delay(3500).slideUp('slow');
</script>