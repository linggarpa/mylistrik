<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <?php foreach ($tarif as $t) { ?>
                <div class="card-body">
                    <?php echo $this->session->flashdata('pesan'); ?>
                    <h4 class="card-title mb-4">Edit Tarif</h4>
                    <form action="<?= base_url('adm/edit_tarif/') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_tarif" value="<?= $t['id_tarif'] ?>">
                        <div class="form-group">
                            <label for="daya" class="col-sm-2 col-form-label">daya</label>
                            <input type="text" class="form-control form-control-user" id="daya" name="daya" value="<?= $t['daya'] ?>">
                            <small class="text-danger"><?php echo form_error('daya'); ?></small>
                        </div>          
                        <div class="form-group">
                            <label for="tarifperkwh" class="col-sm-2 col-form-label"></label>
                            <input type="text" class="form-control form-control-user" onkeyup="formatInputRupiah(this)" id="tarifperkwh" name="tarifperkwh" value="<?= $t['tarifperkwh'] ?>">
                            <small class="text-danger"><?php echo form_error('tarifperkwh'); ?></small>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary mr-2"> Simpan </button>
                            <!-- Tombol ke Halaman Sebelumnya-->
                            <a href="<?= base_url('adm/tarif/') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>

                </div>
                <?php } ?>
            </div>
        </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->