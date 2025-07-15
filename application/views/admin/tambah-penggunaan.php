<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php
    // id pembayaran auto
    foreach ($idP as $p) {
        $IDMax = $p['maxID'];

        $ket = "PGN";

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
                    <h4 class="card-title mb-4">Tambah Penggunaan</h4>
                    <form action="<?= base_url('adm/tambah_penggunaan/') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_penggunaan" value="<?= $ID ?>">
                        <div class="form-group">
                                <label for="id_pelanggan" class="col-sm-2 col-form-label">Pelanggan</label>
                                <select name="id_pelanggan" class="form-control form-control-user">
                                    <option value="">Pilih Pelanggan</option>
                                    <?php
                                    foreach ($pelanggan as $p) { ?>
                                        <option value="<?= $p['id_pelanggan']; ?>"><?= $p['nama_pelanggan']; ?></option> <?php } ?>
                                </select>
                                <small class="text-danger"><?php echo form_error('pelanggan'); ?></small>
                        </div>
                         <div class="form-group">
                                <label for="bulan" class="col-sm-2 col-form-label">Bulan</label>
                                <select name="bulan" class="form-control form-control-user">
                                    <option value="">Pilih Bulan</option>
                                    <option value="1">Januari</option> 
                                    <option value="2">Februari</option> 
                                    <option value="3">Maret</option> 
                                    <option value="4">April</option> 
                                    <option value="5">Mei</option> 
                                    <option value="6">Juni</option> 
                                    <option value="7">Juli</option> 
                                    <option value="8">Agustus</option> 
                                    <option value="9">September</option> 
                                    <option value="10">Oktober</option> 
                                    <option value="11">November</option> 
                                    <option value="12">Desember</option> 
                                </select>
                                <small class="text-danger"><?php echo form_error('bulan'); ?></small>
                        </div>        
                        
                        <div class="form-group">
                            <label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
                            <select name="tahun" class="form-control form-control-user">
                                <option value="">Pilih Tahun</option>
                                <?php 
                                $tahun_sekarang = date('Y');
                                for ($i = $tahun_sekarang; $i >= 2020; $i--) {
                                    echo "<option value=\"$i\">$i</option>";
                                }
                                ?>
                            </select>
                            <small class="text-danger"><?php echo form_error('tahun'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="meter_awal" class="col-sm-2 col-form-label">Meter Awal</label>
                            <input type="text" class="form-control form-control-user" id="meter_awal" name="meter_awal" placeholder="Masukkan Meter Awal">
                            <small class="text-danger"><?php echo form_error('meter_awal'); ?></small>
                        </div>
                        <div class="form-group">
                            <label for="meter_akhir" class="col-sm-2 col-form-label">Meter Akhir</label>
                            <input type="text" class="form-control form-control-user" id="meter_akhir" name="meter_akhir" placeholder="Masukkan Meter Akhir">
                            <small class="text-danger"><?php echo form_error('meter_akhir'); ?></small>
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