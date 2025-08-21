<div class="col-11 grid-margin stretch-card py-5 mt-5" style="margin-left: auto; margin-right: auto">
    <div class="card">
        <div class="card-body">

            <div class="widget">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Pelanggan</th>
                                <th scope="col">Daya</th>
                                <th scope="col">Bulan</th>
                                <th scope="col">Tahun</th>
                                <th scope="col">Pemakaian bulan ini</th>
                                <th scope="col">Total  bayar</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($countTagihan < 1) { ?>
                                <tr>
                                    <td colspan="8">
                                        <h4 class="text-center my-5">Tidak ada tagihan</h4>
                                    </td>
                                </tr>
                                <?php } else {
                                $i = 1;
                                foreach ($Tagihan as $t) :
                                ?>
                                    <tr>
                                        <td scope="row"><?php echo $i . '.'; ?></td>
                                        <td><span><?php echo $t['nama_pelanggan']; ?></span></td>
                                        <td><span><?php echo $t['daya']."KWH"; ?></span></td>
                                        <td><?php echo $nama_bulan[(int)$t['bulan']];?></td>
                                        <td><?php echo $t['tahun']; ?></td>
                                        <td><?php echo $t['jumlah_meter']."KWH"; ?></td>
                                        <td><?php echo "Rp. " . number_format($t['total_bayar']); ?></td>
                                        <td>
                                            <?php
                                                if($t['status_tagihan']=='UNPAID'){
                                            ?>
                                            <a class="btn btn-danger text-light" href="<?= base_url('pelanggan/bayar/') . $t['id_tagihan']; ?>">
                                                BELUM BAYAR
                                            </a>
                                            <?php }elseif($t['status_tagihan']=='PAID'){?>
                                             <a class="btn btn-success text-light" href="<?= base_url('pelanggan/bayar/') . $t['id_tagihan']; ?>">
                                                SUDAH BAYAR
                                            </a>
                                            <?php }elseif($t['status_tagihan']=='PROCESS'){?>
                                                <a class="btn btn-warning text-light" href="<?= base_url('pelanggan/bayar/') . $t['id_tagihan']; ?>">
                                                    PROCESS
                                                </a>
                                            <?php } ?>
                                        </td>
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