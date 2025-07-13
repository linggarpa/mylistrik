<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <?php foreach ($konfirmasi as $k) { ?>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <h4 class="card-title mb-4">NO. <?= $k['id_pembayaran'] ?? 'TG' . str_pad($k['id_tagihan'], 10, '0', STR_PAD_LEFT); ?></h4>

                <table class="table table-borderless">
                    <tr>
                        <td style="width: 200px;">ID Tagihan</td>
                        <td><strong><?= $k['id_tagihan'] ?></strong></td>
                    </tr>
                    <tr>
                        <td>Nama Pelanggan</td>
                        <td><?= $k['nama_pelanggan'] ?></td>
                    </tr>
                    <tr>
                        <td>Periode</td>
                        <td><?= $nama_bulan[(int)$k['bulan_bayar']]?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Pembayaran</td>
                        <td><?= $k['tanggal_pembayaran'] ?></td>
                    </tr>
                        <td>Status</td>
                        <td>
                            <?php if ($k['status'] == 'PROCESS') : ?>
                                <span class="text-warning font-weight-bold">Menunggu Konfirmasi</span>
                            <?php elseif ($k['status'] == 'PAID') : ?>
                                <span class="text-success font-weight-bold">Lunas</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr class="border-top">
                        <td><strong>Total Tagihan</strong></td>
                        <td><strong>Rp <?= number_format($k['total_bayar'] + 2500, 2, ',', '.') ?></strong></td>
                    </tr>
                </table>

                <!-- Tombol Aksi -->
                <div class="mt-4">
                    <a href="<?= base_url('adm/tagihan') ?>" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
