<div class="col-11 grid-margin stretch-card py-5 mt-5" style="margin-left: auto; margin-right: auto">
    <div class="card">
        <div class="card-body">

            <div class="widget">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">ID Pembayaran</th>
                                <th scope="col">Tanggal Bayar</th>
                                <th scope="col">Pembayaran Bulan</th>
                                <th scope="col">Biaya</th>
                                <th scope="col">Biaya Admin</th>
                                <th scope="col">Total Bayar</th>
                                <th scope="col">Struk</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($countRbayar< 1) { ?>
                                <tr>
                                    <td colspan="7">
                                        <h4 class="text-center my-5">Tidak ada Riwayat Bayar</h4>
                                    </td>
                                </tr>
                                <?php } else {
                                $i = 1;
                                foreach ($Rbayar as $R) :
                                ?>
                                    <tr>
                                        <td scope="row"><?php echo $i . '.'; ?></td>
                                        <td><span><?php echo $R['id_pembayaran']; ?></span></td>
                                        <td><span><?= date('d-m-Y', strtotime($R['tanggal_pembayaran'])); ?></span></td>
                                        <td><?php echo $nama_bulan[(int)$R['bulan_bayar']]; ?></td>
                                        <td><?php echo "Rp. " . number_format($R['total_bayar']-2500); ?></td>
                                        <td><?php echo "Rp. " . number_format($R['biaya_admin']); ?></td>
                                        <td><?php echo "Rp. " . number_format($R['total_bayar']); ?></td>
                                        <td><a class="btn btn-success" href="<?= base_url('pelanggan/struk/') . $R['id_pembayaran']; ?>"><i class="fas fa-fw fa-file"></i> Lihat</a></td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>