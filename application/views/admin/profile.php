        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <?php echo $this->session->flashdata('pesan'); ?>
            <!-- Main Content -->
            <div id="content">
                <?php foreach ($profile as $p) {  ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Profil</h1>
                    
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <form action="<?= base_url('adm/edit_profile/') ?>" method="post" enctype="multipart/form-data">

                                <div class="form-row">
                                    <div class="form-group w-100">
                                        <label for="idPelanggan">ID User</label>
                                        <input type="text" class="form-control" id="id_user" value="<?= $p['id_user']?>" disabled>
                                    </div>
                                    
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="namaLengkap">Nama Lengkap</label>
                                        <input type="text" class="form-control" name="nama_admin" id="namaLengkap" value="<?= $p['nama_admin']?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" id="username" value="<?= $p['username']?>">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Ubah Profil</button>
                                

                            </form>
                            <?php } ?>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->
