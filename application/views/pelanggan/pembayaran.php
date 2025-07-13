 <div class="container py-5" style="margin-top: 100px;">
    <div class="row justify-content-center">
      <div class="col-md-6">
          <?php
          // id pembayaran auto
                foreach ($idP as $p) {
                    $IDMax = $p['maxID'];

                    $ket = "PYM";

                    if ($IDMax++) {
                        $ID = sprintf("%03s", $IDMax);
                    } else {
                        $ID = $ket . sprintf("%03s", $IDMax);
                    }
                foreach ($pembayaran as $p) {
                $totalbyr= $p['total_bayar'] + 2500
            ?>

        <div class="card shadow">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Nomor Tagihan: <?php echo $p['id_tagihan']; ?></h5>
          </div>
          <div class="card-body">
           
            <!-- Ringkasan Tagihan -->
            <dl class="row mb-4">
              <dt class="col-sm-4">Nama Pelanggan:</dt>
              <dd class="col-sm-8"><?php echo $p['nama_pelanggan']; ?></dd>

              <dt class="col-sm-4">Nomor KWH:</dt>
              <dd class="col-sm-8"><?php echo $p['nomor_kwh']; ?></dd>

              <dt class="col-sm-4">Periode:</dt>
              <dd class="col-sm-8"><?php echo $nama_bulan[(int)$p['bulan']] .' '. $p['tahun'];?></dd>

              <dt class="col-sm-4">Jumlah Meter:</dt>
              <dd class="col-sm-8"><?php echo $p['jumlah_meter']; ?>KWH</dd>

              <dt class="col-sm-4">Tarif Per KWH:</dt>
              <dd class="col-sm-8"><?php echo "Rp. " . number_format($p['tarifperkwh']); ?></dd>
              
              <dt class="col-sm-4">Biaya Admin:</dt>
              <dd class="col-sm-8">Rp 2.500,00</dd>

              <dt class="col-sm-4">Total Tagihan:</dt>
              <dd class="col-sm-8 fw-bold text-success"><?php echo "Rp. " . number_format($totalbyr); ?></dd>
            </dl>
            
            <!-- Form Pembayaran -->
            <form action="<?= base_url('pelanggan/GoBayar'); ?>" method="post">
              <input type="hidden" name="id_pembayaran" value="<?= $ID ?>">
              <input type="hidden" name="id_tagihan" value="<?= $p['id_tagihan']?>">
              <input type="hidden" name="id_pelanggan" value="<?= $p['id_pelanggan']?>">
              <input type="hidden" name="bulan" value="<?= $p['bulan']?>">
              <input type="hidden" name="totalbyr" value="<?= $totalbyr?>">

              <div class="mb-3">
                <label for="tgl_bayar" class="form-label">Tanggal Pembayaran</label>
                <input type="date" class="form-control" id="tgl_bayar" name="tgl_bayar" required>
              </div>
              <div class="mb-3">
                <label for="nominal_bayar" class="form-label">Nominal bayar</label>
                <input type="text" class="form-control" id="nominal_bayar" name="nominal_bayar"  onkeyup="formatInputRupiah(this)" placeholder="Masukan nominal" required >
              </div>

              <div class="d-flex justify-content-end mr-5">
                <button type="submit" class="btn btn-danger">Bayar</button>
              </div>
            </form>
            

          </div>
        </div>

        <?php }
            } ?>

      </div>
    </div>
  </div>