<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Struk Pembayaran Listrik</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      margin: 0;
      padding: 20px;
    }
    .struk {
      max-width: 300px;
      margin: auto;
      border: 1px dashed #000;
      padding: 10px;
    }
    h2, h3 {
      text-align: center;
      margin: 5px 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    td {
      padding: 4px 0;
    }
    .total {
      font-weight: bold;
      border-top: 1px solid #000;
      padding-top: 5px;
      margin-top: 10px;
    }
    .footer {
      text-align: center;
      margin-top: 15px;
      font-style: italic;
    }
  </style>
</head>
<body>
  <div class="struk">
    <h2>PLN PASCA BAYAR</h2>
    <h3>STRUK PEMBAYARAN</h3>
    <?php foreach ($pembayaran as $p) : ?>
    <table>
      <tr>
        <td>ID Pembayaran</td>
        <td>: <?php echo $p['id_pembayaran']; ?></td>
      </tr>
      <tr>
        <td>Nama</td>
        <td>: <?php echo $p['nama_pelanggan']; ?></td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td>: <?php echo $p['alamat']; ?></td>
      </tr>
      <tr>
        <td>Bulan</td>
        <td>: <?= $nama_bulan[(int)$p['bulan_bayar']]; ?></td>
      </tr>
      <tr>
        <td>Jumlah Pemakaian</td>
        <td>: <?php echo $p['jumlah_meter'] ; ?>KWH</td>
      </tr>
      <tr class="total">
        <td>Total Bayar</td>
        <td>: <?php echo "Rp. " . number_format($p['total_bayar']); ?></td>
      </tr>
      <tr>
        <td>Status</td>
        <td>: Lunas</td>
      </tr>
      <tr>
        <td>Tanggal Bayar</td>
        <td>: <?php echo $p['tanggal_pembayaran']; ?></td>
      </tr>
    </table>
    <?php endforeach ?>

    <div class="footer">
      Terima kasih telah melakukan pembayaran.<br>
      PLN - Melayani Anda Lebih Baik
    </div>
  </div>
</body>
</html>
