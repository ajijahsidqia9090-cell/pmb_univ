<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// cek sudah daftar atau belum
$cek = mysqli_query($conn,"SELECT * FROM pendaftaran WHERE id_user='$id_user'");
$sudah = mysqli_fetch_assoc($cek);

// ambil data pendaftaran untuk cek status lulus (UNTUK MENU)
$daftar = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM pendaftaran WHERE id_user='$id_user'
"));

if(isset($_POST['daftar'])){

    $nama_lengkap   = $_POST['nama_lengkap'] ?? '';
    $nik            = $_POST['nik'] ?? '';
    $tempat_lahir   = $_POST['tempat_lahir'] ?? '';
    $tanggal_lahir  = $_POST['tanggal_lahir'] ?? '';
    $alamat         = $_POST['alamat'] ?? '';
    $asal_sekolah   = $_POST['asal_sekolah'] ?? '';
    $jurusan        = $_POST['jurusan'] ?? '';

    if($nama_lengkap == '' || $nik == ''){
        die("Data tidak boleh kosong!");
    }

    mysqli_query($conn,"
        INSERT INTO pendaftaran 
        (id_user, nama_lengkap, nik, tempat_lahir, tanggal_lahir, alamat, asal_sekolah, jurusan_pilihan, status_berkas, hasil_seleksi, status_daftar_ulang)
        VALUES 
        ('$id_user','$nama_lengkap','$nik','$tempat_lahir','$tanggal_lahir','$alamat','$asal_sekolah','$jurusan','pending','belum','belum')
    ");

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran PMB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f4f6fb;
        }

        .navbar{
            background: linear-gradient(135deg,#1e3a8a,#06b6d4);
            box-shadow:0 4px 15px rgba(0,0,0,0.1);
        }

        .nav-link{
            color:#fff !important;
            margin-right:6px;
            border-radius:8px;
            padding:6px 10px;
        }

        .nav-link:hover{
            background:rgba(255,255,255,0.15);
        }

        .user-badge{
            background:rgba(255,255,255,0.2);
            padding:6px 12px;
            border-radius:20px;
            color:white;
            font-size:13px;
            margin-right:10px;
        }

        .card{
            border:none;
            border-radius:16px;
            box-shadow:0 8px 20px rgba(0,0,0,0.08);
        }
    </style>
</head>

<body>

<!-- NAVBAR FIX FINAL (MAHASISWA STYLE ADMIN) -->
<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container-fluid">

        <a class="navbar-brand" href="dashboard.php">PMB Mahasiswa</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- KIRI KOSONG BIAR MENU KE KANAN -->
            <ul class="navbar-nav me-auto"></ul>

            <!-- MENU + USER DIKANAN -->
            <ul class="navbar-nav align-items-center">

                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="pendaftaran.php">Pendaftaran</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="upload_dokumen.php">Dokumen</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="pembayaran.php">Pembayaran</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="hasil.php">Hasil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="ospek.php">OSPEK</a>
                </li>

                <?php if(($daftar['hasil_seleksi'] ?? '')=='lulus'){ ?>
                <li class="nav-item">
                    <a class="nav-link text-warning fw-bold" href="daftar_ulang.php">
                        Daftar Ulang
                    </a>
                </li>
                <?php } ?>

                <!-- PEMISAH -->
                <li class="nav-item mx-2 text-white">|</li>

                <!-- HALO USER -->
                <li class="nav-item">
                    <span class="nav-link text-white">
                        👋 Halo, <?php echo $_SESSION['nama']; ?>
                    </span>
                </li>

                <!-- LOGOUT -->
                <li class="nav-item ms-2">
                    <a href="../logout.php" class="btn btn-danger btn-sm">
                        Logout
                    </a>
                </li>

            </ul>

        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-4">

    <!-- TOMBOL KEMBALI -->
    <a href="dashboard.php" class="btn btn-secondary mb-3">
        ← Kembali ke Dashboard
    </a>

    <div class="card shadow">
        <div class="card-body">

            <h3>Pendaftaran Mahasiswa Baru</h3>
            <hr>

            <?php if($sudah){ ?>

                <div class="alert alert-success">
                    Kamu sudah melakukan pendaftaran.
                </div>

            <?php } else { ?>

                <form method="POST">

                    <div class="mb-2">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label>NIK</label>
                        <input type="text" name="nik" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" required></textarea>
                    </div>

                    <div class="mb-2">
                        <label>Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" class="form-control" required>
                    </div>

                    <div class="mb-2">
                        <label>Jurusan Pilihan</label>
                        <select name="jurusan" class="form-control" required>
                            <option value="Informatika">Informatika</option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="Bisnis Digital">Bisnis Digital</option>
                        </select>
                    </div>

                    <button type="submit" name="daftar" class="btn btn-success">
                        Daftar Sekarang
                    </button>

                </form>

            <?php } ?>

        </div>
    </div>

</div>

</body>
</html>