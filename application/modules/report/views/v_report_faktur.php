<br>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Laporan Pembelian</h3>

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
                <label for="faktur_type" class="col-sm-2 col-form-label">Tipe Laporan</label>
                <div class="col-sm-5">
                    <select class="form-control select2" style="width: 100%;" id="faktur_type" name="faktur_type">
                        <option value="-">-- Pilih Tipe --</option>
                        <option value="detail">Detail Pembelian</option>
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
            let faktur_type = $('#faktur_type').val();
            let from_date = $('#from_date').val();
            let to_date = $('#to_date').val();

            if (faktur_type=='-') {
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
            window.open('<?= base_url('report/faktur_preview/') ?>' + from_date + '/' + to_date + '/' + faktur_type , '_blank');
        });
    });
    $('#notifications').slideDown('slow').delay(3500).slideUp('slow');
</script>