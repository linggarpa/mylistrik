<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2 bg-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-md font-weight-bold text-white text-uppercase mb-1">
                                Pelanggan
                            </div>
                            <div class="h1 mb-0 font-weight-bold text-white">
                                <?= $pelanggan; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('admin/pelanggan'); ?>">
                                <i class="fas fa-bars fa-3x text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- jika user_level LVL001 tampilkan  -->
        <?php if ($this->session->userdata('id_level') == 'LVL001'): ?>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 bg-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-md font-weight-bold text-white text-uppercase mb-1">
                                Petugas
                            </div>
                            <div class="h1 mb-0 font-weight-bold text-white">
                                <?= $petugas; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('admin/petugas'); ?>">
                                <i class="fas fa-donate fa-3x text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 bg-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-md font-weight-bold text-white text-uppercase mb-1">
                                Total Tagihan
                            </div>
                            <div class="h1 mb-0 font-weight-bold text-white">
                                <?= $totalTagihan; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('admin/tagihan'); ?>">
                                <i class="fas fa-wallet fa-3x text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2 bg-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-md font-weight-bold text-white text-uppercase mb-1">
                                Total Penggunaan
                            </div>
                            <div class="h1 mb-0 font-weight-bold text-white">
                                <?= $totalPenggunaan; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('admin/penggunaan'); ?>">
                                <i class="fas fa-clipboard-check fa-3x text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2 bg-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-md font-weight-bold text-white text-uppercase mb-1">
                                Total Pendapatan
                            </div>
                            <div class="h1 mb-0 font-weight-bold text-white">
                               <?php echo ($totalPendapatan !== null) ? "Rp " . number_format($totalPendapatan, 0, ',', '.') : 'Rp 0';?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('admin/pencairanDana'); ?>">
                                <i class="fas fa-hand-holding-usd fa-3x text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->