<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php
    // id pembayaran auto
    foreach ($idP as $p) {
        $IDMax = $p['maxID'];

        $ket = "PLG";

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
                    <h4 class="card-title mb-4">Tambah Pelanggan</h4>
                    <form action="<?= base_url('adm/tambah_pelanggan/') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_pelanggan" value="<?= $ID ?>">
                        <div class="form-group">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Masukkan Username" value="<?= set_value('username');?>">
                            <small class="text-danger"><?php echo form_error('username'); ?></small>
                        </div>          
                        <div class="form-group">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <input type="password" name="password" id="password" cols="30" rows="10" class="form-control form-control-user" placeholder="Masukkan password"></input>
                            <small class="text-danger"><?php echo form_error('password'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="nomor_kwh" class="col-sm-2 col-form-label">Nomor KWH</label>
                            <input type="number" class="form-control form-control-user" id="nomor_kwh" name="nomor_kwh" placeholder="Masukkan Nomor KWH" value="<?= set_value('nomor_kwh');?>">
                            <small class="text-danger"><?php echo form_error('nomor_kwh'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="nama_pelanggan" class="col-sm-2 col-form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control form-control-user" id="nama_pelanggan" name="nama_pelanggan" placeholder="Masukkan Nama" value="<?= set_value('nama_pelanggan'); ?>">
                            <small class="text-danger"><?php echo form_error('nama_pelanggan'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <textarea type="text" class="form-control form-control-user" id="alamat" name="alamat" placeholder="Masukkan Alamat" ></textarea>
                            <small class="text-danger"><?php echo form_error('alamat'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="tarif" class="col-sm-2 col-form-label">Daya</label>
                            <select name="tarif" class="form-control form-control-user" >
                                <option value="">Pilih Daya</option>
                                <?php
                                foreach ($tarif as $t) { ?>
                                    <option value="<?= $t['id_tarif']; ?>" <?= set_select('tarif', $t['id_tarif']); ?>><?= $t['daya']; ?>KWH</option> <?php } ?>
                            </select>
                            <small class="text-danger"><?php echo form_error('tarif'); ?></small>
                        </div>
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary mr-2"> Simpan </button>
                            <!-- Tombol ke Halaman Sebelumnya-->
                            <a href="<?= base_url('adm/pelanggan/') ?>" class="btn btn-secondary">Batal</a>
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