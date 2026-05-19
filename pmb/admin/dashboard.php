<?php
session_start();
include '../config/koneksi.php';

// proteksi
if(!isset($_SESSION['id_user'])){
    header("Location: ../login.php");
    exit;
}

if($_SESSION['role'] != 'admin'){
    echo "Akses ditolak!";
    exit;
}

// DATA
$total_user   = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM users"));
$total_daftar = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM pendaftaran"));
$total_bayar  = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM pembayaran WHERE status_verifikasi='lunas'"));
$total_lulus  = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM pendaftaran WHERE hasil_seleksi='lulus'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Dashboard Admin PMB</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f6fb;
}

/* NAVBAR */
.navbar{
    background: linear-gradient(135deg,#1e3a8a,#06b6d4);
    box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

.navbar-brand{
    font-weight:bold;
}

/* MENU STYLE */
.nav-link{
    color:#fff !important;
    margin-right:6px;
    padding:6px 10px;
    border-radius:8px;
    transition:0.2s;
}

.nav-link:hover{
    background:rgba(255,255,255,0.15);
}

/* CARD */
.stat-card{
    border:none;
    border-radius:16px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.25s;
}

.stat-card:hover{
    transform:translateY(-6px);
}

.stat-title{
    font-size:14px;
    opacity:0.7;
}

.stat-number{
    font-size:30px;
    font-weight:bold;
}
</style>

</head>

<body>

<!-- NAVBAR FIX FINAL -->
<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container-fluid">

        <a class="navbar-brand" href="#">PMB Admin</a>

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
                    <a class="nav-link" href="verifikasi_berkas.php">Berkas</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="verifikasi_pembayaran.php">Pembayaran</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="pengumuman.php">Pengumuman</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="data_ospek.php">OSPEK</a>
                </li>

                <!-- PEMISAH -->
                <li class="nav-item mx-2 text-white">|</li>

                <!-- HALO ADMIN -->
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

    <h3 class="mb-4">Dashboard Admin</h3>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card stat-card p-3 bg-white">
                <div class="stat-title">Total User</div>
                <div class="stat-number text-primary"><?= $total_user ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card p-3 bg-white">
                <div class="stat-title">Pendaftar</div>
                <div class="stat-number text-success"><?= $total_daftar ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card p-3 bg-white">
                <div class="stat-title">Lunas</div>
                <div class="stat-number text-warning"><?= $total_bayar ?></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card p-3 bg-white">
                <div class="stat-title">Lulus</div>
                <div class="stat-number text-danger"><?= $total_lulus ?></div>
            </div>
        </div>

    </div>

    <div class="card mt-4 stat-card">
        <div class="card-body">
            <h5>📊 Sistem PMB</h5>
            <p class="text-muted mb-0">
                Selamat datang di dashboard admin. Kelola seluruh proses PMB dari pendaftaran hingga OSPEK.
            </p>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>