<?php
session_start();
include '../config/koneksi.php';

if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

/* =========================
   DATA PENDAFTARAN
========================= */
$data = mysqli_query($conn,"
    SELECT * FROM pendaftaran 
    WHERE id_user='$id_user'
");
$row = mysqli_fetch_assoc($data);

if(!$row){
    die("Kamu belum daftar!");
}

/* =========================
   NAVBAR SUPPORT
========================= */
$daftar = $row;
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Hasil Seleksi</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f6fb;
    font-family:system-ui;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(135deg,#1e3a8a,#06b6d4);
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

/* CARD */
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

    <!-- BACK BUTTON -->
    <a href="dashboard.php" class="btn btn-secondary mb-3">
        ← Kembali ke Dashboard
    </a>

    <div class="card">
        <div class="card-body">

            <h3>Hasil Seleksi PMB</h3>
            <hr>

            <p><b>Nama:</b> <?= $_SESSION['nama']; ?></p>

            <?php if($row['hasil_seleksi'] == 'lulus'){ ?>

                <div class="alert alert-success">
                    🎉 Selamat! Kamu <b>LULUS</b>
                </div>

            <?php } elseif($row['hasil_seleksi'] == 'tidak lulus'){ ?>

                <div class="alert alert-danger">
                    ❌ Maaf, kamu <b>TIDAK LULUS</b>
                </div>

            <?php } else { ?>

                <div class="alert alert-warning">
                    ⏳ Hasil seleksi belum diumumkan
                </div>

            <?php } ?>

        </div>
    </div>

</div>

</body>
</html>