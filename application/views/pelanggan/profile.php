<div class="container py-5" style="margin-top: 100px;">
    <?php echo $this->session->flashdata('pesan'); ?>
    <?php foreach ($profile as $p) { ?>
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4>Profil</h4>
      <a href="<?= base_url('Pelanggan/ubah_password/') ?>" class="btn btn-primary">
        <i class="bi bi-lock"></i> Ubah Password
      </a>
    </div>

    <div class="card">
      <div class="card-body">
        <form action="<?= base_url('Pelanggan/edit_profile/') ?>" method="post" enctype="multipart/form-data">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="idPelanggan" class="form-label">ID Pelanggan:</label>
              <input type="text" id="id_Pelanggan" class="form-control" value="<?= $p['id_pelanggan'] ?>" disabled>
            </div>
            <div class="col-md-6">
              <label for="username" class="form-label">Username:</label>
              <input type="text" id="username" class="form-control" value="<?= $p['username'] ?>" name="username">
                <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="namaLengkap" class="form-label">Nama Lengkap:</label>
              <input type="text" id="nama_pelanggan" class="form-control" value="<?= $p['nama_pelanggan'] ?>" name="nama_pelanggan">
                <?= form_error('nama_pelanggan', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="col-md-6">
              <label for="alamat" class="form-label">Alamat:</label>
              <input type="text" id="alamat" class="form-control" value="<?= $p['alamat'] ?>" name="alamat">
            <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-6">
              <label for="nomorKwh" class="form-label">Nomor KWH:</label>
              <input type="text" id="nomor_Kwh" class="form-control" value="<?= $p['nomor_kwh'] ?>" name="nomor_kwh">
            <?= form_error('nomor_kwh', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
            <div class="col-md-6">
              <label for="tarif" class="form-label">Pilih Daya:</label>
                <select name="tarif" class="form-select" id="tarif">
                    <option value="<?= $p['id_tarif']; ?>"><?= $p['daya']; ?> Watt</option>
                        <option value="<?= $p['id_tarif']; ?>" <?= set_select('tarif', $p['id_tarif']); ?>>
                            <?= $p['daya']; ?> Watt
                    </option>
                </select>
                <?= form_error('tarif', '<small class="text-danger pl-3">', '</small>'); ?>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Ubah profil</button>
        </form>
        <?php } ?>
      </div>
    </div>
  </div>