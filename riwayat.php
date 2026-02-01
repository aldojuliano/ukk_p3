<?php
session_start();
include '../config/koneksi.php';
if ($_SESSION['role'] != 'siswa') {
    header("Location: ../login.php");
}

$nis_user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Riwayat Aspirasi Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .badge-menunggu {
            background-color: #ffc107;
            color: black;
        }

        .badge-proses {
            background-color: #17a2b8;
        }

        .badge-selesai {
            background-color: #28a745;
        }
    </style>
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Siswa Panel</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="form_aspirasi.php">Buat Aduan</a>
                <a class="nav-link active" href="riwayat.php">Riwayat</a>
                <a class="nav-link text-danger" href="../logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 text-primary"><i class="fas fa-history me-2"></i>Histori Aspirasi Anda</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Umpan Balik Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nis_user = $_SESSION['user'];

                            $query = mysqli_query($conn, "
    SELECT 
        i.tgl_input,
        k.ket_kategori,
        i.lokasi,
        i.ket,
        a.status,
        a.feedback
    FROM input_aspirasi i
    JOIN kategori k ON i.id_kategori = k.id_kategori
    LEFT JOIN aspirasi a ON i.id_pelaporan = a.id_pelaporan
    WHERE i.nis = '$nis_user'
    ORDER BY i.id_pelaporan DESC
");

                            if (!$query) {
                                die("Query error: " . mysqli_error($conn));
                            }
                            ?>

                            <?php if (mysqli_num_rows($query) > 0) { ?>
                                <?php while ($d = mysqli_fetch_array($query)) { ?>
                                    <tr>
                                        <td><?= date('d M Y', strtotime($d['tgl_input'])) ?></td>
                                        <td><?= $d['ket_kategori'] ?></td>
                                        <td><?= $d['lokasi'] ?></td>
                                        <td><?= $d['ket'] ?></td>
                                        <td><?= $d['status'] ?? 'menunggu' ?></td>
                                        <td><?= $d['feedback'] ?? '-' ?></td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Belum ada aspirasi</td>
                                </tr>
                            <?php } ?>



                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>