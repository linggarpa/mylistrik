<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php
    // id pembayaran auto
    foreach ($idT as $t) {
        $IDMax = $t['maxID'];

        $ket = "TRF";

        if ($IDMax++) {
            $ID = sprintf("%03s", $IDMax);
        } else {
            $ID = $ket . sprintf("%03s", $IDMax);
        }
    ?>
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php echo $this->session->flashdata('pesan'); ?>
                    <h4 class="card-title mb-4">Tambah Tarif</h4>
                    <form action="<?= base_url('adm/tambah_tarif/') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_tarif" value="<?= $ID ?>">
                        <div class="form-group">
                            <label for="daya" class="col-sm-2 col-form-label">Daya</label>
                            <input type="text" class="form-control form-control-user" id="daya" name="daya" placeholder="Masukkan Username">
                            <small class="text-danger"><?php echo form_error('daya'); ?></small>
                        </div>          
                       
                        <div class="form-group">
                            <label for="tarifperkwh" class="col-sm-2 col-form-label">Tarif PerKWH</label>
                            <input type="text" class="form-control form-control-user" id="tarifperkwh" onkeyup="formatInputRupiah(this)" name="tarifperkwh" placeholder="Masukkan Nama">
                            <small class="text-danger"><?php echo form_error('tarifperkwh'); ?></small>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary mr-2"> Simpan </button>
                            <!-- Tombol ke Halaman Sebelumnya-->
                            <a href="<?= base_url('adm/tarif/') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    <?php } ?>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->