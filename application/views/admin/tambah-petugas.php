<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php
    // id pembayaran auto
    foreach ($idU as $u) {
        $IDMax = $u['maxID'];

        $ket = "USR";

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
                    <h4 class="card-title mb-4">Tambah Petugas</h4>
                    <form action="<?= base_url('adm/tambah_petugas/') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_petugas" value="<?= $ID ?>">
                        <div class="form-group">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Masukkan Username">
                            <small class="text-danger"><?php echo form_error('username'); ?></small>
                        </div>          
                        <div class="form-group">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <input type="password" name="password" id="password" cols="30" rows="10" class="form-control form-control-user" placeholder="Masukkan password"></input>
                            <small class="text-danger"><?php echo form_error('password'); ?></small>
                        </div>
                       
                        <div class="form-group">
                            <label for="nama_admin" class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <input type="text" class="form-control form-control-user" id="nama_admin" name="nama_admin" placeholder="Masukkan Nama">
                            <small class="text-danger"><?php echo form_error('nama_admin'); ?></small>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary mr-2"> Simpan </button>
                            <!-- Tombol ke Halaman Sebelumnya-->
                            <a href="<?= base_url('adm/petugas/') ?>" class="btn btn-secondary">Batal</a>
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