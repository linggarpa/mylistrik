<div class="container d-flex justify-content-center" style="margin-top: 115px;">
    <div class="card shadow-sm" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
            <?php elseif ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
            <?php endif; ?>
            <h5 class="card-title text-center mb-4">Ubah Password</h5>
            <form action="<?= base_url('pelanggan/ubah_password') ?>" method="post">
                <div class="mb-3">
                    <label for="password_lama" class="form-label">Password Lama</label>
                    <input type="password" class="form-control" id="password_lama" name="password_lama" required>
                </div>
                <div class="mb-3">
                    <label for="password_baru" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="password_baru" name="password_baru" required>
                </div>
                <div class="mb-4">
                    <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" required>
                </div>
                <div>
                    <a href="<?= base_url('pelanggan/profile') ?>" class="btn btn-secondary  ml-3">Batal</a>
                    <button type="submit" class="btn btn-primary ">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
