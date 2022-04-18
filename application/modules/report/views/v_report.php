<br>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Laporan Stok</h3>

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
                <label for="stock_type" class="col-sm-2 col-form-label">Tipe Stok</label>
                <div class="col-sm-5">
                    <select class="form-control select2" style="width: 100%;" id="stock_type" name="stock_type">
                        <option value="-">-- Pilih Tipe --</option>
                        <option value="month">Bulan</option>
                        <option value="day">Harian</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="stock_date" class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-2">
                    <input type="date" class="form-control" id="stock_date">
                </div>
            </div>
            <div class="row">
                <hr>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-3">
                    <button class="btn btn-primary" type="button" id="btn_preview" name="btn_preview" value="Preview">Lihat</button>
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
            let stock_type = $('#stock_type').val();
            let stock_date = $('#stock_date').val();

            if (stock_type == '-') {
                Swal.fire('Error!','Choose report type','error');
                return;
            }

            if (!stock_date) {
                Swal.fire('Error!','Choose date','error');
                return;
            }

            //this will redirect us in new tab
            window.open('<?= base_url('report/stock_preview/') ?>' + stock_date + '/' + stock_type , '_blank');
        });
    });
    $('#notifications').slideDown('slow').delay(3500).slideUp('slow');
</script>