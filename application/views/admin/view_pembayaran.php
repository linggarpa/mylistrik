<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <?php echo $this->session->flashdata('pesan'); ?>

                <?= form_error('tagihan', '<div class="alert alert-danger alert-message" role="alert">', '</div>'); ?>
                <!-- Print and PDF download buttons -->
                <a href="<?= base_url('adm/print_laporan_pembayaran')?>" class="btn btn-primary mb-3">
                    <i class="fas fa-print"></i> Print
                </a>
                <div class="widget">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">ID Pembayaran</th>
                                    <th scope="col">Nama Pelanggan</th>
                                    <th scope="col">Periode</th>
                                    <th scope="col">Biaya Admin</th>
                                    <th scope="col">Jumlah Bayar</th>
                                    <th scope="col">Tanggal Bayar</th>
                                    <th scope="col">Konfirmasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = $offset + 1; ?>
                                <?php foreach ($pembayaran as $p) : ?>
                                    <tr>
                                        <td scope="row"><?php echo $i . '.'; ?></td>
                                        <td><span><?php echo $p['id_pembayaran']; ?></span></td>
                                        <td><span><?php echo $p['nama_pelanggan']; ?></span></td>
                                        <td><span><?php echo $nama_bulan[(int)$p['bulan']].' '.$p['tahun']; ?></span></td>
                                        <td><span><?php echo "Rp. " . number_format($p['biaya_admin']); ?></span></td>
                                        <td><span><?php echo "Rp. " . number_format($p['total_bayar']); ?></span></td>
                                        <td><span><?php echo $p['tanggal_pembayaran']; ?></span></td>
                                        <td><span><?php echo $p['nama_admin']; ?></span></td>
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