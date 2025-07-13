<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark warna-navbar fixed-top  ">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="<?= base_url('pelanggan'); ?>"> <img src="<?= base_url('assets/img/'); ?>logo-pln.png" width="60" height="60" alt="Mylistrik">Mylistrik</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 fs-5" style="margin-top: -5px;">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="<?= base_url('pelanggan'); ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('pelanggan/riwayatbayar'); ?>">Riwayat pembayaran</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('auth/logout'); ?>">Logout</a></li>               
            </ul>
        </div>
    </div>
</nav>