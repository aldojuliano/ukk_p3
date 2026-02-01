<?php
include '../config/koneksi.php';
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pengaduan Sarana</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .header {
            border-bottom: 3px double #000;
            padding-bottom: 10px;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header text-center">
        <h2>LAPORAN PENGADUAN SARANA DAN PRASARANA</h2>
        <p>SMK Krian 1 Sidoarjo</p>
        <hr>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Pelapor (NIS)</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $res = mysqli_query($conn, "
            SELECT 
            i.tgl_input,
            i.nis,
            k.ket_kategori,
            i.lokasi,
            i.ket,
            COALESCE(a.status, 'menunggu') AS status
            FROM input_aspirasi i
            JOIN kategori k ON i.id_kategori = k.id_kategori
            LEFT JOIN aspirasi a ON i.id_pelaporan = a.id_pelaporan
            ORDER BY i.tgl_input DESC
");
            $no = 1;
            while ($d = mysqli_fetch_array($res)) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d-m-Y', strtotime($d['tgl_input'])) ?></td>
                    <td><?= $d['nis'] ?></td>
                    <td><?= $d['ket_kategori'] ?></td>
                    <td><?= $d['lokasi'] ?></td>
                    <td><?= $d['ket'] ?></td>
                    <td><?= strtoupper($d['status']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div style="margin-top: 30px; float: right; text-align: center;">
        <p>Kiran, <?= date('d F Y') ?></p>
        <p>Mengetahui, <br>Admin Sarpras</p>
        <br><br>
        <p><strong>( ........................... )</strong></p>
    </div>
</body>

</html>