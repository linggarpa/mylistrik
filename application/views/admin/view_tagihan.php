<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <?php echo $this->session->flashdata('pesan'); ?>

                <?= form_error('tagihan', '<div class="alert alert-danger alert-message" role="alert">', '</div>'); ?>

                <div class="widget">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">ID Tagihan</th>
                                    <th scope="col">ID Penggunaan</th>
                                    <th scope="col">Nama Pelanggan</th>
                                    <th scope="col">Periode</th>
                                    <th scope="col">Jumlah Meter</th>
                                    <th scope="col">Jumlah Bayar</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = $offset + 1; ?>
                                <?php foreach ($tagihan as $t) : ?>
                                    <tr>
                                        <td scope="row"><?php echo $i . '.'; ?></td>
                                        <td><span><?php echo $t['id_tagihan']; ?></span></td>
                                        <td><span><?php echo $t['id_penggunaan']; ?></span></td>
                                        <td><span><?php echo $t['nama_pelanggan']; ?></span></td>
                                        <td><span><?php echo $nama_bulan[(int)$t['bulan']].' '.$t['tahun']; ?></span></td>
                                        <td><span><?php echo $t['jumlah_meter']; ?>KWH</span></td>
                                        <td><span><?php echo "Rp. " . number_format($t['total_bayar']); ?></span></td>
                                        <td>
                                        <?php
                                            if($t['status']=='PROCESS'){
                                        ?>
                                            <a href="<?php echo base_url(); ?>adm/konfirmasi/<?php echo $t['id_tagihan']; ?>" class="btn btn-warning mr-2"><i class="far fa-fw fa-edit mr-2"></i><?= $t['status'] ?></a>
                                        <?php }elseif($t['status']=='PAID'){
                                        ?>
                                            <a href="<?php echo base_url(); ?>adm/paid/<?php echo $t['id_pembayaran']; ?>" class="btn btn-success mr-2"><i class="far fa-fw fa-edit mr-2"></i><?= $t['status'] ?></a>
                                        <?php }elseif($t['status']=='UNPAID'){
                                        ?>
                                            <a href="" class="btn btn-danger mr-2"><i class="far fa-fw fa-edit mr-2"></i><?= $t['status'] ?></a>
                                        <?php } ?>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <ul class="pagination justify-content-center">
                        <!-- First Page Link -->
                        <?php if ($page > 1) { ?>
                            <li class="page-item"><a class="page-link" href="?page=1">First</a></li>
                            <li class="page-item"><a class="page-link" href="?page=<?= $page - 1; ?>">Previous</a></li>
                        <?php } ?>

                        <!-- Page Numbers -->
                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php } ?>

                        <!-- Next Page Link -->
                        <?php if ($page < $totalPages) { ?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $page + 1; ?>">Next</a></li>
                            <li class="page-item"><a class="page-link" href="?page=<?= $totalPages; ?>">Last</a></li>
                        <?php } ?>
                    </ul>
                </div>

            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->