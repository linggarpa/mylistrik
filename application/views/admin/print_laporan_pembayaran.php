<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Laporan Pembayaran</title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .mt-5 {
            margin-top: 5rem;
        }

        .mb-5 {
            margin-bottom: 5rem;
        }

        .no-print {
            display: none;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="text-center">Laporan Pencairan Donasi</h2>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Pembayaran</th>
                    <th>Nama Pelanggan</th>
                    <th>Periode</th>
                    <th>Biaya Admin</th>
                    <th>Jumlah Bayar</th>
                    <th>Tanggal Bayar</th>
                    <th>Konfirmasi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($pembayaran) < 1) { ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data untuk bulan ini.</td>
                    </tr>
                <?php } else { ?>
                    <?php $i = 1; ?>
                    <?php foreach ($pembayaran as $p) : ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $p['id_tagihan']; ?></td>
                            <td><?= $p['nama_pelanggan']; ?></td>
                            <td><?= $nama_bulan[(int)$p['bulan_bayar']]; ?></td>
                            <td><?= "Rp. " . number_format($p['biaya_admin'], 2, ',', '.'); ?></td>
                            <td><?= "Rp. " . number_format($p['total_bayar'], 2, ',', '.'); ?></td>
                            <td><?= $p['tanggal_pembayaran']; ?></td>
                            <td><?= $p['nama_admin']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php } ?>
            </tbody>
        </table>

        <script type="text/javascript">
            window.print();
        </script>

</body>

</html>