<?php
include 'config/koneksi.php';

if (isset($_POST['register'])) {
    $nis      = mysqli_real_escape_string($conn, $_POST['nis']);
    $kelas    = mysqli_real_escape_string($conn, $_POST['kelas']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Cek apakah NIS sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM siswa WHERE nis='$nis'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('NIS sudah terdaftar! Silakan login.'); window.location='login.php';</script>";
    } else {
        // Simpan ke database
        $query = mysqli_query($conn, "INSERT INTO siswa (nis, kelas, password) VALUES ('$nis', '$kelas', '$password')");
        if ($query) {
            echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Gagal registrasi, coba lagi.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Siswa | Aspirasi Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background: #f4f6f9; height: 100vh; display: flex; align-items: center; }
        .card { border: none; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .btn-success { border-radius: 10px; padding: 12px; font-weight: 600; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card p-4">
                <div class="text-center mb-4">
                    <i class="fas fa-user-plus fa-3x text-success mb-2"></i>
                    <h4>Daftar Akun Siswa</h4>
                    <p class="text-muted">Lengkapi data diri untuk menyampaikan aspirasi</p>
                </div>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">NIS (Nomor Induk Siswa)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                            <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS Anda" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                            <input type="text" name="kelas" class="form-control" placeholder="Contoh: XII RPL 1" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Buat Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="******" required>
                        </div>
                    </div>
                    <button type="submit" name="register" class="btn btn-success w-100 mb-3">Daftar Sekarang</button>
                    <div class="text-center">
                        <a href="login.php" class="text-muted small text-decoration-none">Sudah punya akun? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>