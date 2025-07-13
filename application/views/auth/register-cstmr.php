<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block text-center">
                    <img src="<?= base_url('assets/img/'); ?>logo-pln.png" width="380" height="480">
                </div>
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
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Daftar Akun!</h1>
                            </div>
                            <form class="user" method="post" action="<?= base_url('auth/register'); ?>">
                                <input type="hidden" name="id_pelanggan" value="<?= $ID ?>">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username Lengkap" value="<?= set_value('username'); ?>">
                                    <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control form-control-user" id="nomor_kwh" name="nomor_kwh" placeholder="Nomor KWH" value="<?= set_value('nomor_kwh'); ?>">
                                    <?= form_error('nomor_kwh', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                 <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="nama_pelanggan" name="nama_pelanggan" placeholder="Nama Lengkap" value="<?= set_value('nama_pelanggan'); ?>">
                                    <?= form_error('nama_pelanggan', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                 <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="alamat" name="alamat" placeholder="Alamat" value="<?= set_value('alamat'); ?>">
                                    <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <select name="tarif" class="form-control" id="tarif">
                                        <option value="">Pilih daya</option>
                                        <?php foreach ($tarif as $t): ?>
                                            <option value="<?= $t['id_tarif']; ?>" <?= set_select('tarif', $t['id_tarif']); ?>>
                                                <?= $t['daya']; ?> Watt
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-info btn-user btn-block">
                                    Register
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="<?= base_url('auth'); ?>">Kamu sudah punya akun? Login!</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

</div>