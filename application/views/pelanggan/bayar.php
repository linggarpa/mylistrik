<div class="container d-flex justify-content-center" style="margin-top: 150px;">
    <div class="card shadow mb-4" style="max-width: 500px; width: 100%;">
        <div class="card-body">
            
            <?php
                foreach ($bayar as $b) {
                $totalbyr= $b['total_bayar'] + 2500
            ?>

            <h5 class="font-weight-bold mb-4"><?= $b['id_tagihan'] ?></h5>

            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <td><?= $b['nama_pelanggan'] ?></td>
                    </tr>
                    <tr>
                        <th>Nomor KWH</th>
                        <td><?= $b['nomor_kwh'] ?></td>
                    </tr>
                    <tr>
                        <th>Periode</th>
                        <td><?= $nama_bulan[(int)$b['bulan']] .' '. $b['tahun'];?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Meter</th>
                        <td><?= $b['jumlah_meter'] ?></td>
                    </tr>
                    <tr>
                        <th>Total Tagihan</th>
                        <td><?= "Rp. " . number_format($b['total_bayar']); ?></td>
                    </tr>
                    <tr>
                        <th>Biaya Admin</th>
                        <td>Rp 2.500,00</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><span class="text-success font-weight-bold"><?= $b['status_tagihan'] ?></span></td>
                    </tr>
                </tbody>
            </table>

            <hr>

            <table class="table table-borderless">
                <tr>
                    <th style="width: 260px;">Total</th>
                    <td class="text-right"><strong><?= "Rp. " . number_format($totalbyr); ?></strong></td>
                </tr>
            </table>
            <?php } ?>
            <hr>
            <?php
                if($b['status_tagihan']=='UNPAID'){
            ?>
                <a class="btn btn-danger w-100 text-light" href="<?= base_url('pelanggan/halamanBayar/') . $b['id_tagihan']; ?>">
                    Bayar Sekarang
                </a>
            <?php }elseif($b['status_tagihan']=='PAID'){ ?>
                <button type="button" class="btn btn-success w-100 text-light" onclick="history.back();">
                    Kembali
                </button>
            <?php }elseif($b['status_tagihan']=='PROCESS'){?>
                <button type="button" class="btn btn-warning w-100 text-light" onclick="history.back();">
                    Kembali
                </button>
            <?php } ?>

        </div>
        
    </div>
</div>
