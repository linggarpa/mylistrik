<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion p-2" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <!-- <img src="<?= base_url('assets/img/'); ?>logo-pln.png" width="80" height="100"> -->
        </div>
        <div class="sidebar-brand-text mx-3">Mylisrtrik</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading"><?php echo $this->session->userdata('username'); ?></div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link pb-0" href="<?= base_url('adm'); ?>">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link pb-0" href="<?= base_url('adm/pelanggan'); ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Pelanggan</span>
        </a>
    </li>
    <?php if ($this->session->userdata('id_level') == 'LVL001'): ?>
    <li class="nav-item">
        <a class="nav-link pb-0" href="<?= base_url('adm/petugas'); ?>">
            <i class="fas fa-fw fa-bars"></i>
            <span>Petugas</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link pb-0" href="<?= base_url('adm/tarif'); ?>">
            <i class="fas fa-fw fa-donate"></i>
            <span>Tarif</span>
        </a>
    </li>
    <?php endif; ?>
    <li class="nav-item">
        <a class="nav-link pb-0" href="<?= base_url('adm/penggunaan'); ?>">
            <i class="fas fa-fw fa-clipboard-check"></i>
            <span>penggunaan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link pb-0" href="<?= base_url('adm/tagihan'); ?>">
            <i class="fas fa-fw fa-clipboard-check"></i>
            <span>Tagihan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link pb-0" href="<?= base_url('adm/pembayaran'); ?>">
            <i class="fas fa-fw fa-wallet"></i>
            <span>Pembayaran</span>
        </a>
    </li>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->