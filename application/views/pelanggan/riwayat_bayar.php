<div class="col-11 grid-margin stretch-card py-5 mt-5" style="margin-left: auto; margin-right: auto">
    <div class="card">
        <div class="card-body">

            <?php
                $id_pelanggan = $this->session->userdata('id_pelanggan');
                $queryRbayar = "SELECT * FROM pembayaran where id_pelanggan = '$id_pelanggan'";
                $Rbayar = $this->db->query($queryRbayar)->result_array();

                $countRbayar = $this->db->query($queryRbayar)->num_rows();
                $nama_bulan = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember'
            ];
            ?>

            <div class="widget">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">ID Pembayaran</th>
                                <th scope="col">Tanggal Bayar</th>
                                <th scope="col">Pembayaran Bulan</th>
                                <th scope="col">Biaya Admin</th>
                                <th scope="col">Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($countRbayar< 1) { ?>
                                <tr>
                                    <td colspan="6">
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
                                        <td><?php echo "Rp. " . number_format($R['biaya_admin']); ?></td>
                                        <td><?php echo "Rp. " . number_format($R['total_bayar']); ?></td>
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