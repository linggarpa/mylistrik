<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark warna-navbar fixed-top  ">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="<?= base_url('pelanggan'); ?>"> <img src="<?= base_url('assets/img/'); ?>logo-pln.png" width="60" height="60" alt="Mylistrik">Mylistrik</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 fs-5" style="margin-top: -5px;">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= base_url('pelanggan'); ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('pelanggan/riwayatbayar'); ?>">Riwayat pembayaran</a></li>
                <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Akun</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="<?= base_url('pelanggan/profile'); ?>">
                                    <i class="fas fa-fw fa-user"></i>Profile Saya
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item" href="<?= base_url('auth/logout'); ?>">
                                    <i class="fas fa-fw fa-sign-out-alt"></i>Logout
                                </a>
                            </li>
                        </ul>
                </li>           
            </ul>
        </div>
    </div>
</nav>