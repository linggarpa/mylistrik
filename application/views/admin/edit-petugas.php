<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <?php foreach ($petugas as $p) { ?>
                <div class="card-body">
                    <?php echo $this->session->flashdata('pesan'); ?>
                    <h4 class="card-title mb-4">Edit Petugas</h4>
                    <form action="<?= base_url('adm/edit_petugas/') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_user" value="<?= $p['id_user'] ?>">
                        <div class="form-group">
                            <label for="username" class="col-sm-2 col-form-label">username</label>
                            <input type="text" class="form-control form-control-user" id="username" name="username" value="<?= $p['username'] ?>">
                            <small class="text-danger"><?php echo form_error('username'); ?></small>
                        </div>          
                        <div class="form-group">
                            <label for="nama_admin" class="col-sm-2 col-form-label">Nama Petugas</label>
                            <input type="text" class="form-control form-control-user" id="nama_admin" name="nama_admin" value="<?= $p['nama_admin'] ?>">
                            <small class="text-danger"><?php echo form_error('nama_admin'); ?></small>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary mr-2"> Simpan </button>
                            <!-- Tombol ke Halaman Sebelumnya-->
                            <a href="<?= base_url('adm/petugas/') ?>" class="btn btn-secondary">Batal</a>
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